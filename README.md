# KONFIGURASI SERVER UBUNTU 22 BY MUGIEW

```bash
sudo apt update && sudo apt upgrade -y
```

## BUAT USER BARU SEBAGAI PENGGANTI ROOT

1. Tambahkan user baru

```bash
adduser userbaru
```

2. Berikan hak akses sudo kepada user baru

```bash
gpasswd -a userbaru sudo
```

3. Buka file sshd_config kemudian ubah PermitRootLogin menjadi "no"

```bash
nano /etc/ssh/sshd_config
```

4. Restart daemon sshd

```bash
systemctl restart sshd
```

5. Restart VPS dan akses kembali menggunakan userbaru untuk mengikuti langkah selanjutnya

```bash
sudo reboot now
```

## SETUP TERMINAL ZSH + OHMYZSH + POWERLEVEL10K & PLUGIN

1. Install ZSH

```bash
sudo apt install zsh
```

2. Jadikan ZSH menjadi terminal default

```bash
chsh -s /usr/bin/zsh
```

3. Reboot VPS

```bash
sudo reboot now
```

4. Install OH MY ZSH

```bash
sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
```

5. Install font powerline

```bash
sudo apt-get install fonts-powerline
```

6. Install [powerlevel10k](https://github.com/romkatv/powerlevel10k)

```bash
git clone --depth=1 https://github.com/romkatv/powerlevel10k.git ${ZSH_CUSTOM:-$HOME/.oh-my-zsh/custom}/themes/powerlevel10k
```

7. Download plugin auto suggest & syntax highlight

```bash
git clone https://github.com/zsh-users/zsh-autosuggestions.git $ZSH_CUSTOM/plugins/zsh-autosuggestions
git clone https://github.com/zsh-users/zsh-syntax-highlighting.git $ZSH_CUSTOM/plugins/zsh-syntax-highlighting
```

8. Ketikkan perintah ```sudo nano ~/.zshrc```, cari ```plugins=(git)``` kemudian replace dengan ```plugins=(git zsh-autosuggestions zsh-syntax-highlighting)```, kemudian cari ```ZSH_THEME="robbyrussell"``` replace dengan ```ZSH_THEME="powerlevel10k/powerlevel10k"```. Selanjutnya reboot VPS.

```bash
sudo reboot now
```

## Install PHP 8.4 & Mysql

1. Add repository ```Ondřej Surý``` untuk mendapatkan versi PHP 8.4

```bash
sudo add-apt-repository ppa:ondrej/php && sudo apt update && sudo apt upgrade -y
```

2. Install PHP 8.4 FPM beserta extensi yang umum diperlukan

```bash
sudo apt install ca-certificates curl php8.4-fpm php8.4-mbstring php8.4-dom php8.4-tokenizer php8.4-readline php8.4-sqlite3 php8.4-curl php8.4-mysql php8.4-zip php8.4-intl -y
```

3. Install mysql

```bash
sudo apt install mysql-server
```

4. Ketik perintah ```sudo mysql``` untuk masuk ke dalam mysql mode, kemudian berikan password default untuk root

```d
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'ISI-PASSWORD-KAMU-DISINI';
FLUSH PRIVILEGES;
EXIT;
```

5. Karena sudah di set password maka untuk masuk kembali ke dalam mysql mode, ketikkan perintah ```sudo mysql -u root -p```, kemudian enter dan masukkan password yang tadi kamu isi.

6. Buat database baru dan juga user baru sekalian berikan akses database yang di buat kepada user baru.

```d
CREATE DATABASE database_baru;
CREATE USER 'user_baru'@'localhost' IDENTIFIED BY 'password_user_baru';
GRANT ALL PRIVILEGES ON database_baru.* TO 'user_baru'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

7. Cek user baru pada mysql dengan mengetikkan ```mysql -u user_baru -p``` kemudian masukkan password.

8. Cek database yang diberikan sebelumnya kepada user_baru

```mysql
SHOW DATABASES;
```

9. Pastikan database ada di list, jika tidak ada ulangi langkah ke 6 dan pastikan kamu tidak typo. Jika database ada di list kemudian exit dan part ini telah selesai.

```mysql
EXIT;
```

## Install [Bun](https://bun.sh/), [Composer](https://getcomposer.org/), [FrankenPHP](https://frankenphp.dev/), dan [Laravel Octane](https://laravel.com/docs/11.x/octane)

1. Install Bun

```bash
curl -fsSL https://bun.sh/install | bash
```

2. Install Composer

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

3. Install FrankenPHP

```bash
curl https://frankenphp.dev/install.sh | sh
sudo mv frankenphp /usr/local/bin/
```

4. Install laravel Octane

```bash
composer global require laravel/installer
echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin"' >> ~/.zshrc
laravel new yourproject
cd yourproject
composer require laravel/octane
php artisan octane:install --server=frankenphp
```

## Konfigurasi Caddyfile

1. Buat file Caddyfile

```bash
cd && nano Caddyfile
```

2. Paste dan konfigurasikan sesuai path directory folder kamu, kemudian save

```vim
{
    frankenphp {
        worker /home/userbaru/yourproject/public/frankenphp-worker.php 8
    }

    your-domain.com {
        root * /home/userbaru/yourproject/public
        encode zstd br gzip
        php_server
    }
}
```

3. Langkah selanjutnya tinggal jalankan FrankenPHP di server kamu

 ```bash
sudo frankenphp run --config Caddyfile
```

## Source

Saya mengucapkan terimakasih banyak kepada orang-orang yang telah memberikan informasi dan tutorial seputar teknologi. Sehingga saya bisa membuat artikel konfigurasi yang saya tulis ini.

Sumber penulisan saya di dapatkan dari:

1. [YouTube Orang IT](https://www.youtube.com/@orang_it)
2. [YouTube Aji Diyantoro](https://www.youtube.com/watch?v=kALMxgVMZF4&t=1465s)
3. [YouTube Programmer Zaman Now](https://www.youtube.com/watch?v=3qe6BEJ34Co)
4. Blog [Satria Janaka](https://medium.com/@satriajanaka09/setup-zsh-oh-my-zsh-powerlevel10k-on-ubuntu-20-04-c4a4052508fd) di [medium.com](https://medium.com/)
5. Blog [RumahWeb](https://www.rumahweb.com/journal/cara-membuat-user-baru-sebagai-pengganti-user-root-di-vps/)
