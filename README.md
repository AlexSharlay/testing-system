## Тестовое задание

### При 1 запуске приложения нужно выполнить следующие действия:
1) Запустить контейнеры докера:
    ```bash
    docker-compose up -d
   ```
2) Установить библиотеки из Composer:
    ```bash
    docker-compose run --rm testing-system-php-cli composer install
   ```
3) Выполнить миграции:
    ```bash
    docker-compose run --rm testing-system-php-cli php bin/console doctrine:migrations:migrate --no-interaction
    ```
4) Установить фикстуры:
    ```bash
    docker-compose run --rm testing-system-php-cli php bin/console doctrine:fixtures:load --no-interaction
    ```


### Можно также воспользоваться утилитой make:
1) Инициализация приложения: команда соберет контейнеры, установит библиотеки из composer, выполнит миграции, установит фикстуры
    ```bash
    make init
    ```

### При повторном запуске приложения:
1) 
    ```bash
    docker-compose up -d
    ```
   
### Приложение доступно по адресу:

[http://localhost:8080](http://localhost:8080)