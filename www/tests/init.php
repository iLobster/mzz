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

require_once systemConfig::$pathToSystem . 'resolver/init.php';
require_once systemConfig::$pathToSystem . 'resolver/casesFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/testFileResolver.php';

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

fileLoader::load('db/DB');
fileLoader::load('filters/init');
fileLoader::load('request/response');
fileLoader::load('template/mzzSmarty');
fileLoader::load('request/rewrite');
fileLoader::load('request/requestParser');

fileLoader::load('toolkit');
fileLoader::load('toolkit/stdToolkit');
fileLoader::load('toolkit/systemToolkit');

fileLoader::load('dataspace/arrayDataspace');

fileLoader::load('iterators/mzzIniFilterIterator');

fileLoader::load('action');
fileLoader::load('timer.factory');
fileLoader::load('cache');


$toolkit = systemToolkit::getInstance();
$toolkit->addToolkit(new stdToolkit(new config(systemConfig::$pathToConf . 'common.ini')));

$toolkit->getTimer();

?>