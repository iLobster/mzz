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

            require_once systemConfig::$pathToSystem . 'resolver/init.php';
            require_once systemConfig::$pathToSystem . 'core/fileLoader.php';

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
            fileLoader::load('request/httpResponse');
            fileLoader::load('request/url');
            fileLoader::load('filters/init');

            fileLoader::load('config/config');
            fileLoader::load('request/requestParser');
            fileLoader::load('frontcontroller/frontController');

            fileLoader::load('db/DB');
            fileLoader::load('simple/simple.view');
            fileLoader::load('dataspace/arrayDataspace');

            fileLoader::load('iterators/mzzIniFilterIterator');

            fileLoader::load('toolkit');
            fileLoader::load('toolkit/stdToolkit');
            fileLoader::load('toolkit/systemToolkit');

            fileLoader::load('action');
            fileLoader::load('cache');

            $toolkit = systemToolkit::getInstance();
            $toolkit->addToolkit(new stdToolkit(new config(systemConfig::$pathToConf . 'common.ini')));

            $response = new httpResponse();
            $request = $toolkit->getRequest();

            $filter_chain = new filterChain($response, $request);

            $filter_chain->registerFilter(new timingFilter());
            $filter_chain->registerFilter(new contentFilter());

            $filter_chain->process();

            $response->send();
        } catch (mzzException $e) {
            $e->printHtml();
        } catch (Exception $e) {
            $name = get_class($e);
            $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
            $e->setName($name);
            $e->printHtml();
        }
    }
}

?>