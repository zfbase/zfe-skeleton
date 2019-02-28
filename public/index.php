<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../constants.php';

(new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
))->bootstrap()->run();
