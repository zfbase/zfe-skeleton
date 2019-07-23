#!/usr/bin/env bash

# Скрипт для актуализации тестовой БД

# Вариант 1 с миграциями
echo "1. Remove all from test database"
mysql -uzfe -pzfe -Nse 'SHOW TABLES' zfe_test | while read table; do
    mysql -uzfe -pzfe -e "SET FOREIGN_KEY_CHECKS = 0; DROP TABLE $table" zfe_test;
done

echo "2. Load initial.sql for test database"
cd ./assets/
#mysqldump -uzfe -pzfe zfe > `date +%Y%m%d`dump.sql
#mysql -uzfe -pzfe zfe_test < `date +%Y%m%d`dump.sql
mysql -uzfe -pzfe zfe_test < initial.sql

cd ../
echo "3. Apply migrations for test database"
APPLICATION_ENV=testing composer tool migrate
[[ $? != 0 ]] && { cd ../; echo "Migration failed"; exit 1; }

echo "4. Creating working dump.sql of test database for tests"
mysqldump -uzfe -pzfe zfe_test > tests/_data/dump.sql

# Вариант 2 без миграций - просто берем дамп
#mysqldump -v -uzfe -pzfe zfe > tests/_data/dump.sql