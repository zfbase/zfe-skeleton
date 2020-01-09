## Установка
Начальное приложение на [ZFE](https://github.com/zfbase/zfe/).

1. Установка из репозитория
  ```shell
  composer create-project -s dev zfbase/zfe-skeleton .
  npm install && npm update
  ```

2. Настройка базы данных
2.1. Укажите параметры подключения к СУБД в файле `application/configs/doctrine.ini`.
2.2. Загрузите в СУБД начальную схему БД из файла `assets/initial.sql`.

3. Создайте первого пользователя
  ```shell
  composer tool create-user
  ```
