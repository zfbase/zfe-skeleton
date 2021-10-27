#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->getBootstrap()
    ->bootstrap('config')
    ->bootstrap('loader')
    ->bootstrap('doctrine')
;

// Производительность и
// PHP Fatal error:  Uncaught Zend_Exception: No entry is registered for key 'user' in library/Zend/Registry.php:147
Doctrine_Manager::connection()->unsetAttribute(Doctrine_Core::ATTR_LISTENER);
Doctrine_core::debug(false);
History::$globalRealtimeWhiteHistory = false;
Editors::setCurrent(Editors::findOneBy('login', 'retroman'));

$config = Zend_Registry::get('config');
$manager = ZFE_Tasks_Manager::getInstance($config);

$writer = new Zend_Log_Writer_Stream('php://stdout');
$logger = new Zend_Log($writer);
$manager->setLogger($logger);

while (true) {
    $tasks = $manager->findAllToDo();
    $managed = $manager->manage($tasks);
    sleep(1);
}
