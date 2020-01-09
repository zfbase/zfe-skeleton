<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(__DIR__ . '/../application'));

// забиваю жестко
// во избежания потери данных в рабочей БД
define('APPLICATION_ENV', 'testing');

define('TEST_DATA_PATH', APPLICATION_PATH . '/../tests/_data/');
define('DUMP_SQL', (getenv('DUMP_SQL') ? getenv('DUMP_SQL') : TEST_DATA_PATH . 'dump.sql'));

require_once __DIR__ . '/../vendor/autoload.php';

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->getBootstrap()->bootstrap('Config');
$application->getBootstrap()->bootstrap('Loader');
$application->getBootstrap()->bootstrap('Doctrine');
