<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * core: ядро mzz
 *
 * @package system
 * @version 0.1.1
 */
class core
{
    /**
     * запуск приложения
     *
     */
    public function run()
    {
        try {

            require_once systemConfig::$pathToSystem . '/resolver/init.php';
            require_once systemConfig::$pathToSystem . '/core/fileLoader.php';

            $baseresolver = new compositeResolver();
            $baseresolver->addResolver(new sysFileResolver());
            $baseresolver->addResolver(new appFileResolver());

            $resolver = new compositeResolver();
            $resolver->addResolver(new classFileResolver($baseresolver));
            $resolver->addResolver(new moduleResolver($baseresolver));
            $resolver->addResolver(new configFileResolver($baseresolver));
            $resolver->addResolver(new libResolver($baseresolver));
            $cachingResolver = new cachingResolver($resolver);

            fileLoader::setResolver($cachingResolver);
            fileLoader::load('exceptions/init');
            $dispatcher = new errorDispatcher();
            fileLoader::load('request/httpResponse');
            fileLoader::load('request/url');

            fileLoader::load('cache/iCacheable');

            fileLoader::load('simple');
            fileLoader::load('simple/simple.mapper');
            fileLoader::load('simple/simple.view');
            fileLoader::load('simple/simple.controller');
            fileLoader::load('simple/simple.factory');

            fileLoader::load('filters/init');

            fileLoader::load('config/config');
            fileLoader::load('request/requestParser');
            fileLoader::load('frontcontroller/frontController');

            fileLoader::load('db/DB');
            fileLoader::load('dataspace/arrayDataspace');

            fileLoader::load('iterators/mzzIniFilterIterator');

            fileLoader::load('toolkit');
            fileLoader::load('toolkit/stdToolkit');
            fileLoader::load('toolkit/systemToolkit');

            fileLoader::load('action');

            $toolkit = systemToolkit::getInstance();
            $toolkit->addToolkit(new stdToolkit(/*new config(systemConfig::$pathToConf . '/common.ini')*/));

            $response = $toolkit->getResponse();
            $request = $toolkit->getRequest();

            $filter_chain = new filterChain($response, $request);

            $filter_chain->registerFilter(new timingFilter());
            $filter_chain->registerFilter(new sessionFilter());
            $filter_chain->registerFilter(new userFilter());
            $filter_chain->registerFilter(new contentFilter());
            $filter_chain->process();
            $response->send();
        } catch (Exception $e) {
            if (!($e instanceof mzzException))  {
                $name = get_class($e);
                $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile(), $e->getTrace());
                $e->setName($name);
                throw $e;
            } else {
                throw $e;
            }
        }
    }
}

?>