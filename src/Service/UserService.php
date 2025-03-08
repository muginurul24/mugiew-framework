<?php

namespace Mugiew\Galeano\Service;

use Mugiew\Galeano\Config\Database;
use Mugiew\Galeano\Domain\User;
use Mugiew\Galeano\Model\UserRegisterRequest;
use Mugiew\Galeano\Repository\UserRepository;
use Mugiew\Galeano\Model\UserRegisterResponse;
use Mugiew\Galeano\Exception\ValidationException;
use Mugiew\Galeano\Model\UserLoginRequest;
use Mugiew\Galeano\Model\UserLoginResponse;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);

            if ($user != null) {
                throw new ValidationException('User already exists');
            }

            $user = new User();
            $user->id = $request->id;
            $user->username = $request->username;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->register($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();

            return $response;
        } catch (\Exception $exception) {
            Database::rollBackTransaction();
            throw $exception;
        }
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if ($request->id == null || $request->username == null || $request->password == null || trim($request->id) == '' || trim($request->username) == '' || trim($request->password) == '') {
            throw new ValidationException('Id, username and password are required');
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->id);

        if ($user == null) {
            throw new ValidationException('Id or password is wrong');
        }

        if (!password_verify($request->password, $user->password)) {
            throw new ValidationException('Id or password is wrong');
        }

        $response = new UserLoginResponse();
        $response->user = $user;

        return $response;
    }

    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if ($request->id == null || $request->password == null || trim($request->id) == '' || trim($request->password) == '') {
            throw new ValidationException('ID and Password are required');
        }
    }
}
