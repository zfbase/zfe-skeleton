#!/usr/bin/env bash

# Миграции БД: подготовка и начало работы
# https://confluence.archive.systems/x/IIDgAQ

mysql -v -u root -e "CREATE USER IF NOT EXISTS 'zfe'@'%' IDENTIFIED BY 'zfe'"

#mysql -v -u root -e "DROP DATABASE IF EXISTS zfe"
mysql -v -u root -e "CREATE DATABASE IF NOT EXISTS zfe CHARACTER SET utf8 COLLATE utf8_unicode_ci"
mysql -v -u root -e "GRANT ALL ON zfe.* TO 'zfe'@'%'"
mysql -v -u zfe -pzfe zfe < ./initial.sql

# Создане БД для автоматического тестирования
# mysql -u root -e "DROP DATABASE IF EXISTS zfe_test"
mysql -v -u root -e "CREATE DATABASE IF NOT EXISTS zfe_test CHARACTER SET utf8 COLLATE utf8_unicode_ci"
mysql -v -u root -e "GRANT ALL ON zfe_test.* TO 'zfe'@'%'"
mysql -v -u zfe -pzfe zfe_test < ./initial.sql


# Вызываем утилиты из корня проекта
cd ../

mysql -v -uzfe -pzfe -e "select TABLE_NAME from information_schema.TABLES where TABLE_NAME='migration_version'" > .migrated
LEN=`cat .migrated | wc -c`
if (( $LEN <= 117 ))
then
    # таблица migration_version отсутсвует, поэтому
    # считаем, что этот скрипт запущен впервые:
    # сгенерируем модели и записи в schema.yml
    echo "No migration_version table, it's the first time"
    composer tool doctrine generate-models-db
    composer tool doctrine generate-yaml-models
fi

rm -f ./.migrated
composer tool migrate
