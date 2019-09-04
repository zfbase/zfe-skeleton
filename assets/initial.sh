#!/usr/bin/env bash

# Миграции БД: подготовка и начало работы
# https://confluence.archive.systems/x/IIDgAQ

USER=zfe
PASS=zfe
NAME=zfe

while getopts ":r" ARG; do
  case $ARG in
    r)
      mysql -v -u root -e "DROP DATABASE IF EXISTS $NAME"
      mysql -v -u root -e "DROP DATABASE IF EXISTS ${NAME}_test"
      ;;
    *) ;;
  esac
done

mysql -v -u root -e "CREATE USER IF NOT EXISTS '$USER'@'%' IDENTIFIED BY '$PASS'"

mysql -v -u root -e "CREATE DATABASE IF NOT EXISTS $NAME CHARACTER SET utf8 COLLATE utf8_unicode_ci"
mysql -v -u root -e "GRANT ALL ON $NAME.* TO '$USER'@'%'"
mysql -v -u $USER -p$PASS $NAME < ./initial.sql

# Создане БД для автоматического тестирования
mysql -v -u root -e "CREATE DATABASE IF NOT EXISTS ${NAME}_test CHARACTER SET utf8 COLLATE utf8_unicode_ci"
mysql -v -u root -e "GRANT ALL ON ${NAME}_test.* TO '$USER'@'%'"

mysql -v -u $USER -p$PASS ${NAME}_test < ./initial.sql

# создаем директорию для хранения миграций
mkdir -v -p ./doctrine/migrations

# Вызываем утилиты из корня проекта
cd ../
composer tool migrate

# возвращаемся обратно и обновляем initial.sql
cd ./assets
echo "DUMP SCHEMA AND DATA TO UPDATE initial.sql"
mysqldump -v -u $USER -p$PASS --ignore-table=$NAME.history $NAME > ./initial.sql
mysqldump -v -u $USER -p$PASS --no-data $NAME history >> ./initial.sql
