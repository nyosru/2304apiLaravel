# 2304api
api сервисы 

# запуск на mac 

1) создаём пустую папку и в ней в теминале

    git clone https://github.com/nyosru/2304apiLaravel.git .

2) ставим композер пакеты

    php composer.phar i

3) создаём файл настроек (копированием из примера)

    cp .env.example .env

4) запускаем Laravel в докере в фоновом режиме

    ./vendor/bin/sail up -d
    предложит выбор .. выбирайте например mysql = 0
    
в результате выполнения команды получаем ответ
[+] Running 3/3
 ⠿ Network lara2_sail              Created                                                                                 0.1s
 ⠿ Container lara2-mysql-1         Started                                                                                 3.8s
 ⠿ Container lara2-laravel.test-1  Started                                                                                 6.3s

5) заходим в окнтейнер с ларой

    docker exec -it **** bash 
    (вместо звёздочек используйте название контейнера что у вас в терминале высветилось где test, у меня это  )
    docker exec -it lara2-laravel.test-1 bash

6) в этом контейнере, генерируем ключ 

    php artisan key:generate


7) проверяем что видим стартовую страницу ЛАравель

    http://localhost/

8) переходим к установке nuxt из 2-го репозитория

    https://github.com/nyosru/test230421nuxt


# ----- автор чудной штуки ----

    Сергей Бакланов 
    https://php-cat.com