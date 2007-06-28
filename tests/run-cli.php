<?php
//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ALL);

$application_path = dirname(__FILE__);

try {
    require_once 'init.php';
    require_once 'testsFinder.php';
    require_once 'testsCliRunner.php';

    $toolkit = systemToolkit::getInstance();
    $request = $toolkit->getRequest();
    $response = $toolkit->getResponse();

    $filter_chain = new filterChain($response, $request);
    $filter_chain->registerFilter(new timingFilter());
    $filter_chain->registerFilter(new testsCliRunner());
    $filter_chain->process();

    $response->send();
} catch (Exception $e) {
    $name = get_class($e);
    $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
    $e->setName($name);
    throw $e;
}
?>