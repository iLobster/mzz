<?php
// ядро

fileResolver::includer('config', 'configFactory');
fileResolver::includer('request', 'requestParser');
fileResolver::includer('frontcontroller', 'frontcontroller');
fileResolver::includer('errors', 'error');
fileResolver::includer('template', 'mzzSmarty');
fileResolver::includer('core', 'File');
fileResolver::includer('request', 'httprequest');
class core
{
    // запуск приложения
    function run()
    {
        $requestParser = requestParser::getInstance();

        $application = $requestParser->get('section');
        $action = $requestParser->get('action');

        $action = 'list';

        $frontcontroller = new frontController($application, $action);
        $template = $frontcontroller->getTemplate();

        $smarty = mzzSmarty::getInstance();
        echo $smarty->fetch($template);
    }
}

?>