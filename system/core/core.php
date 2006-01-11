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
            fileLoader::load('template/mzzSmarty');
            fileLoader::load('core/ErrorHandler');
            fileLoader::load('core/registry');
            fileLoader::load('core/response');
            fileLoader::load('filters/init');

            fileLoader::load('config/config');
            fileLoader::load('request/rewrite');
            fileLoader::load('request/httpRequest');
            fileLoader::load('request/requestParser');
            fileLoader::load('frontController');
            fileLoader::load('core/sectionMapper');
            fileLoader::load('db/dbFactory');
            fileLoader::load('simple/simple.view');


            $smarty = new mzzSmarty();
            $smarty->template_dir  = systemConfig::$pathToApplication . 'templates';
            $smarty->compile_dir   = systemConfig::$pathToTemp . 'templates_c';
            $smarty->plugins_dir[] = systemConfig::$pathToSystem . 'template/plugins';
            $smarty->debugging = DEBUG_MODE;

            $registry = Registry::instance();
            $config = new config(systemConfig::$pathToConf . 'common.ini');

            $registry->setEntry('rewrite', 'Rewrite');
            $registry->setEntry('httprequest', 'HttpRequest');
            $registry->setEntry('config', $config);
            $registry->setEntry('smarty', $smarty);
            $registry->setEntry('htmlquickform', 'HTML_QuickForm');

            $response = new response();

            $filter_chain = new filterChain($response);

            $filter_chain->registerFilter(new timingFilter());
            $filter_chain->registerFilter(new contentFilter());

            $filter_chain->process();

            $response->send();
        } catch (mzzException $e) {
            $e->printHtml();
        } catch (Exception $e) {
            $name = get_class($e);
            $e = new mzzException($e->getMessage(), $e->getCode());
            $e->setName($name);
            $e->printHtml();
        }
    }
}

?>