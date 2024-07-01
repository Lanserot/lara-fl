Laravel пет проект для глубокого изучения

# Старт #
- composer install
- npm install
- создаем бд и прописываем в конфиге
- npm run dev (нужно при работе)

# Накатка бд #
- php artisan migrate
- php artisan db:seed

# Перезаписать бд #
- php artisan migrate:refresh
- php artisan db:seed

composer install
npm run dev
.

# Swagger #
api/documentation/

# Прочее #
```
php artisan jwt:secret
```
# Старт докер #
1. <a href="https://www.docker.com/products/docker-desktop/">Docker desktop</a> не ниже 4.18.0
2. В настройках докера установить `Use WSL 2 based engine`
3. В командной строке выполняем
```
wsl --set-default-version 2
wsl --install -d Ubuntu-22.04
```
4. Переносим ssh-ключи в WSL или генерируем новые
```
cp -r /mnt/c/Users/папка_пользователя/.ssh ~/
chmod 600 ~/.ssh/id_rsa
```
5. Меняем конфиг WSL, чтобы композер мог нормально выдать разрешения файлам. Открываем конфиг в nano
```
sudo nano /etc/wsl.conf
```
Вставляем в конфиг, сохраняем
```
[automount]
enabled = true
options = "metadata"
mountFsTab = false
```
6. Ставим утилиту make
```
sudo apt install make
```
7. Закрываем окно с WSL.
8. Открываем командную строку <strong>от имени администратора</strong>.\
Тушим WSL, заодно назначаем дистриб умолчательным.\
Затем снова логинимся в WSL-машину.
```
wsl --terminate Ubuntu-22.04
wsl --set-default Ubuntu-22.04
wsl
```
9. запускам докер скрипт из корня проекта и надеемся, что всё работает
```
./bash.sh
```
