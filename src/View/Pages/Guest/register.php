<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <?php if (isset($data['error'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $data['error']; ?>
                            </div>
                        <?php endif; ?>
                        <form action="/register" method="post" class="user">
                            <div class="form-group">
                                <input type="text" name="id" class="form-control form-control-user" id="id"
                                    placeholder="ID" value="<?= $_POST['id'] ?? ''; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user" id="username"
                                    placeholder="Username" value="<?= $_POST['username'] ?? ''; ?>" autocomplete="off">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="repeatPassword" class="form-control form-control-user"
                                        id="exampleRepeatPassword" placeholder="Repeat Password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                            <hr>
                            <a href="#" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Register with Google
                            </a>
                            <a href="#" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                            </a>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="/">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>