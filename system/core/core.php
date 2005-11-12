<?php
// ядро
fileResolver::includer('core', 'response');
fileResolver::includer('filters', 'filterchain');
fileResolver::includer('filters', 'timingfilter');
fileResolver::includer('filters', 'contentfilter');
fileResolver::includer('filters', 'resolvingfilter');

class core
{
    // запуск приложения
    function run()
    {
        $response = new response();

        $filter_chain = new filterChain($response);

        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new resolvingFilter());
        $filter_chain->registerFilter(new contentFilter());

        $filter_chain->process();
        //$filter_chain->registerFilter(new );

        $response->send();
    }
}

?>