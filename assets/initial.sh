#!/usr/bin/env bash

# Миграции БД: подготовка и начало работы
# https://confluence.archive.systems/x/IIDgAQ

mysql -u root -e "CREATE USER IF NOT EXISTS 'zfe'@'%' IDENTIFIED BY 'zfe'"

mysql -u root -e "DROP DATABASE IF EXISTS zfe"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS zfe CHARACTER SET utf8 COLLATE utf8_unicode_ci"
mysql -u root -e "GRANT ALL ON zfe.* TO 'zfe'@'%'"
mysql -u ebz -pebz zfe < ./sql/initial.sql

# Создане БД для автоматического тестирования
# mysql -u root -e "DROP DATABASE IF EXISTS zfe_test"
# mysql -u root -e "CREATE DATABASE IF NOT EXISTS zfe_test CHARACTER SET utf8 COLLATE utf8_unicode_ci"
# mysql -u root -e "GRANT ALL ON zfe_test.* TO 'zfe'@'%'"
# mysql -u ebz -pebz zfe_test < ./sql/initial.sql

export APPLICATION_ENV=development

cd ./../scripts/
./doctrine-cli generate-models-db
./doctrine-cli generate-yaml-models

./migrate