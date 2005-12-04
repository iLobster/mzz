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
 * Core: ядро mzz
 *
 * @package system
 * @version 0.1
 */
require_once SystemConfig::$pathToSystem . 'resolver/FileResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/CompositeResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/SysFileResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/AppFileResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/ClassFileResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/ModuleResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/ConfigFileResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/LibResolver.php';
require_once SystemConfig::$pathToSystem . 'core/FileLoader.php';
require_once SystemConfig::$pathToSystem . 'core/Fs.php';
require_once SystemConfig::$pathToSystem . 'resolver/DecoratingResolver.php';
require_once SystemConfig::$pathToSystem . 'resolver/CachingResolver.php';
class Core
{
    /**
     * запуск приложения
     *
     * @access public
     */
    public function run()
    {
        $baseresolver = new CompositeResolver();
        $baseresolver->addResolver(new SysFileResolver());
        $baseresolver->addResolver(new AppFileResolver());

        $resolver = new CompositeResolver();
        $resolver->addResolver(new ClassFileResolver($baseresolver));
        $resolver->addResolver(new ModuleResolver($baseresolver));
        $resolver->addResolver(new ConfigFileResolver($baseresolver));
        $resolver->addResolver(new LibResolver($baseresolver));
        $cachingResolver = new CachingResolver($resolver);

        FileLoader::setResolver($cachingResolver);
        FileLoader::load('exceptions/MzzException');
        FileLoader::load('exceptions/FileResolverException');
        FileLoader::load('exceptions/FileException');
        FileLoader::load('exceptions/DbException');
        FileLoader::load('exceptions/RegistryException');
        FileLoader::load('template/MzzSmarty');
        FileLoader::load('core/ErrorHandler');
        FileLoader::load('core/Registry');
        FileLoader::load('core/Response');
        FileLoader::load('filters/FilterChain');
        FileLoader::load('filters/TimingFilter');
        FileLoader::load('filters/ContentFilter');
        FileLoader::load('filters/ResolvingFilter');

        $smarty = new mzzSmarty();
        $smarty->template_dir  = SystemConfig::$pathToApplication . 'templates';
        $smarty->compile_dir   = SystemConfig::$pathToApplication . 'templates/compiled';
        $smarty->plugins_dir[] = SystemConfig::$pathToSystem . 'template/plugins';
        $smarty->debugging = DEBUG_MODE;

        $registry = Registry::instance();
        $registry->setEntry('rewrite', 'Rewrite');
        $registry->setEntry('httprequest', 'HttpRequest');
        $registry->setEntry('config', 'Config');
        $registry->setEntry('smarty', $smarty);

        $response = new Response();

        $filter_chain = new FilterChain($response);

        $filter_chain->registerFilter(new TimingFilter());
        $filter_chain->registerFilter(new ResolvingFilter());
        $filter_chain->registerFilter(new ContentFilter());

        $filter_chain->process();

        $response->send();
    }
}

?>