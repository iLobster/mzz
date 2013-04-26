<?php

//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ALL);

if (empty($application_path)) {
    $application_path = dirname(__FILE__);
}

try {
    require_once 'init.php';
    require_once 'testsFinder.php';
    require_once 'framyHtmlReporter.php';
    require_once 'testsHtmlRunner.php';

    $toolkit = systemToolkit::getInstance();
    $request = $toolkit->getRequest();
    $response = $toolkit->getResponse();
    fileLoader::load('i18n/charset/utf8Wrapper');

    $filter_chain = new filterChain($response, $request);
    $filter_chain->registerFilter(new timingFilter());
    $filter_chain->registerFilter(new sessionFilter());
    $filter_chain->registerFilter(new testsHtmlRunner());
    $filter_chain->process();

    $response->send();

} catch (Exception $e) {
    $name = get_class($e);
    $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
    $e->setName($name);
    throw $e;
}

?>