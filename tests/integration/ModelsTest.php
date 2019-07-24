<?php

namespace Tests\integration;

use PHPUnit\Framework\TestCase;

abstract class ModelsTest extends TestCase {

    function setUp()
    {
        $appIni = APPLICATION_PATH . '/configs/application.ini';
        $this->bootstrap = new \Zend_Application(APPLICATION_ENV, $appIni);

        parent::setUp();

        if (!defined('DUMP_SQL') || empty(DUMP_SQL)) {
            throw new \Exception('Константа DUMP_SQL не определена или пуста');
        } else {
            if (!is_readable(DUMP_SQL)) {
                throw new \Exception(DUMP_SQL . ' не доступен для чтения');
            }
        }

        $config = \Zend_Registry::get('config')->doctrine;
        $driver = isset($config->driver) ? $config->driver : 'mysql';
        if ($driver == 'psql') {
            $cmd = "PGPASSWORD={$config->password} psql -h {$config->host} -p {$config->port} -U {$config->username} {$config->schema}";
        }
        if ($driver == 'mysql') {
            $cmd = "mysql -u {$config->username} -p{$config->password} -h {$config->host} -P {$config->port} {$config->schema}";
        }

        $cmd .= ' < ' . DUMP_SQL;
        shell_exec($cmd);
    }

    function tearDown()
    {
        parent::tearDown();
    }

}
