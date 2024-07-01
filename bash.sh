#!/bin/bash
docker-compose down
docker-compose build
docker-compose up -d

sudo apt-get install php8.1-curl
sudo apt-get install php8.1-dom

sudo apt-get update
sudo apt-get install --reinstall ca-certificates
sudo apt-get install curl

sudo apt-get install php-mysql
sudo apt-get install php-pdo
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
npm install
composer install
php artisan migrate
sudo chmod 777 -R storage/
sudo apt install mysql-client-core-8.0
