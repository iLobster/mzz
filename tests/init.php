<?php
/**
 * Обработчик ошибок simpltest, нужен чтобы отделить мух от котлет :)
 *
 */
function simpletest_error_handler($errno, $errstr, $errfile, $errline) {
    static $count = 0;
    return $count++;
}

require_once dirname(__FILE__)  . '/configs/config.php';
require_once systemConfig::$pathToSystem . '/core/fileLoader.php';
require_once systemConfig::$pathToSystem . '/version.php';

require_once systemConfig::$pathToSystem . '/resolver/init.php';
require_once systemConfig::$pathToSystem . '/resolver/casesFileResolver.php';

$baseresolver = new compositeResolver();

$baseresolver->addResolver(new fileResolver(systemConfig::$pathToTests . '/*'));
$baseresolver->addResolver(new fileResolver(systemConfig::$pathToSystem . '/*'));
$resolver = new compositeResolver();
$resolver->addResolver(new classFileResolver($baseresolver));
$resolver->addResolver(new casesFileResolver($baseresolver));
$resolver->addResolver(new moduleResolver($baseresolver));
$resolver->addResolver(new commonFileResolver($baseresolver));
fileLoader::setResolver($resolver);

fileLoader::load('exceptions/init');
$dispatcher = new errorDispatcher();

set_error_handler('simpletest_error_handler');

fileLoader::load('service/arrayDataspace');
fileLoader::load('orm/mapper');
fileLoader::load('simple/simpleController');

fileLoader::load('libs/simpletest/unit_tester');
fileLoader::load('libs/simpletest/mock_objects');
fileLoader::load('libs/simpletest/reporter');
restore_error_handler();

fileLoader::load('db/init');
fileLoader::load('orm/init');
fileLoader::load('forms/init');
fileLoader::load('filters/init');
fileLoader::load('request/init');
fileLoader::load('template/fSmarty');

fileLoader::load('toolkit/init');

fileLoader::load('simple/init');
fileLoader::load('timer');
fileLoader::load('i18n/init');

$toolkit = systemToolkit::getInstance();
$toolkit->addToolkit(new stdToolkit());

//$toolkit->getTimer();

?>