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
 * @version 0.1
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
            require_once systemConfig::$pathToSystem . 'resolver/fileResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/compositeResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/sysFileResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/appFileResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/classFileResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/moduleResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/configFileResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/libResolver.php';

            require_once systemConfig::$pathToSystem . 'resolver/decoratingResolver.php';
            require_once systemConfig::$pathToSystem . 'resolver/cachingResolver.php';
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
            
            $smarty = new mzzSmarty();
            $smarty->template_dir  = systemConfig::$pathToApplication . 'templates';
            $smarty->compile_dir   = systemConfig::$pathToApplication . 'templates/compiled';
            $smarty->plugins_dir[] = systemConfig::$pathToSystem . 'template/plugins';
            $smarty->debugging = DEBUG_MODE;

            $registry = Registry::instance();
            $registry->setEntry('rewrite', 'Rewrite');
            $registry->setEntry('httprequest', 'HttpRequest');
            $registry->setEntry('config', 'config');
            $registry->setEntry('smarty', $smarty);
            $registry->setEntry('htmlquickform', 'HTML_QuickForm');

            $response = new response();

            $filter_chain = new filterChain($response);

            $filter_chain->registerFilter(new timingFilter());
            $filter_chain->registerFilter(new resolvingFilter());
            $filter_chain->registerFilter(new contentFilter());

            $filter_chain->process();

            $response->send();
        } catch (MzzException $e) {
            $e->printHtml();
        } catch (Exception $e) {
            $e = new MzzException($e->getMessage(), $e->getCode());
            $e->printHtml();
        }
    }
}

?>