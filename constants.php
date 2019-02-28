<?php

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/application'));
defined('ZFE_PATH')         || define('ZFE_PATH',         realpath(__DIR__ . '/vendor/zfbase/zfe/library/ZFE'));
defined('DATA_PATH')        || define('DATA_PATH',        realpath(__DIR__ . '/data'));
defined('ASSETS_PATH')      || define('ASSETS_PATH',      realpath(__DIR__ . '/assets'));
