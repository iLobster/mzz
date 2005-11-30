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
require_once systemConfig::$pathToSystem . 'resolver/fileresolver.php';
require_once systemConfig::$pathToSystem . 'resolver/compositeResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/sysFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/appFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/classFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/moduleResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/configFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/libResolver.php';
require_once systemConfig::$pathToSystem . 'core/fileLoader.php';
require_once systemConfig::$pathToSystem . 'core/Fs.php';
require_once systemConfig::$pathToSystem . 'resolver/decoratingResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/cachingResolver.php';
class core
{
    /**
     * запуск приложения
     *
     * @access public
     *
     */
    public function run()
    {
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
        fileLoader::load('errors/error');
        fileLoader::load('core/Registry');
        fileLoader::load('template/mzzSmarty');
        fileLoader::load('core/response');
        fileLoader::load('filters/filterchain');
        fileLoader::load('filters/timingfilter');
        fileLoader::load('filters/contentfilter');
        fileLoader::load('filters/resolvingfilter');
        fileLoader::load('exceptions/FileException');

        $smarty = new mzzSmarty();
        $smarty->template_dir      = systemConfig::$pathToApplication . 'templates';
        $smarty->compile_dir       = systemConfig::$pathToApplication . 'templates/compiled';
        $smarty->plugins_dir[] = systemConfig::$pathToSystem . 'template/plugins';
        $smarty->debugging = true;

        $registry = Registry::instance();
        $registry->setEntry('rewrite', 'Rewrite');
        $registry->setEntry('httprequest', 'HttpRequest');
        $registry->setEntry('config', 'config');
        $registry->setEntry('smarty', $smarty);

        $response = new response();

        $filter_chain = new filterChain($response);

        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new resolvingFilter());
        $filter_chain->registerFilter(new contentFilter());

        $filter_chain->process();

        $response->send();
    }
}

?>