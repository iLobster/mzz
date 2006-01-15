<?php
/**
 * Обработчик ошибок simpltest, нужен чтобы отделить мух от котлет :)
 *
 */
function simpletest_error_handler($errno, $errstr, $errfile, $errline) {
    static $count = 0;
    return $count++;
}

require_once 'config.php';
require_once systemConfig::$pathToSystem . 'core/fileLoader.php';
require_once systemConfig::$pathToSystem . 'version.php';
require_once systemConfig::$pathToSystem . 'resolver/iResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/compositeResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/fileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/sysFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/appFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/classFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/moduleResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/casesFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/testFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/configFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/libResolver.php';
$baseresolver = new compositeResolver();
$baseresolver->addResolver(new sysFileResolver());
$baseresolver->addResolver(new testFileResolver());
$baseresolver->addResolver(new appFileResolver());
$resolver = new compositeResolver();
$resolver->addResolver(new classFileResolver($baseresolver));
$resolver->addResolver(new casesFileResolver($baseresolver));
$resolver->addResolver(new libResolver($baseresolver));
$resolver->addResolver(new moduleResolver($baseresolver));
$resolver->addResolver(new configFileResolver($baseresolver));
fileLoader::setResolver($resolver);

fileLoader::load('exceptions/init');
fileLoader::load('config/config');

set_error_handler('simpletest_error_handler');
fileLoader::load('libs/simpletest/unit_tester');
fileLoader::load('libs/simpletest/mock_objects');
fileLoader::load('libs/simpletest/reporter');
restore_error_handler();


fileLoader::load('db/dbFactory');
fileLoader::load('filters/init');
fileLoader::load('core/response');
fileLoader::load('template/mzzSmarty');
fileLoader::load('core/registry');
fileLoader::load('request/rewrite');

$rewrite = new Rewrite(fileLoader::resolve('configs/rewrite.xml'));
$registry = Registry::instance();
$registry->setEntry('rewrite', $rewrite);


$registry = Registry::instance();
$config = new config(systemConfig::$pathToConf . 'common.ini');
$registry->setEntry('config', $config);

?>