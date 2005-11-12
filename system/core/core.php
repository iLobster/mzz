<?php
// ядро

fileResolver::includer('config', 'configFactory');
fileResolver::includer('request', 'requestParser');
fileResolver::includer('frontcontroller', 'frontcontroller');
fileResolver::includer('errors', 'error');
fileResolver::includer('template', 'mzzSmarty');
fileResolver::includer('core', 'File');
fileResolver::includer('core', 'response');
fileResolver::includer('request', 'httprequest');
fileResolver::includer('db', 'dbFactory');
fileResolver::includer('filters', 'filterchain');
fileResolver::includer('filters', 'timingfilter');
fileResolver::includer('filters', 'contentfilter');
class core
{
    // запуск приложения
    function run()
    {
        $response = new response();
        
        $filter_chain = new filterChain($response);
        
        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new contentFilter());
        
        $filter_chain->process();
        //$filter_chain->registerFilter(new );
        
        $response->send();
    }
}

?>