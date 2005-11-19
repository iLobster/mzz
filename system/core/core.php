<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
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


require_once SYSTEM_DIR . 'resolver/fileresolver.php';
require_once SYSTEM_DIR . 'resolver/compositeResolver.php';
require_once SYSTEM_DIR . 'resolver/sysFileResolver.php';
require_once SYSTEM_DIR . 'resolver/classFileResolver.php';
require_once SYSTEM_DIR . 'resolver/moduleResolver.php';
require_once SYSTEM_DIR . 'core/fileLoader.php';

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
        
        $resolver = new compositeResolver();
        $resolver->addResolver(new classFileResolver($baseresolver));
        $resolver->addResolver(new moduleResolver($baseresolver));
        
        fileLoader::setResolver($resolver);
        fileLoader::load('core/response');
        fileLoader::load('filters/filterchain');
        fileLoader::load('filters/timingfilter');
        fileLoader::load('filters/contentfilter');
        fileLoader::load('filters/resolvingfilter');


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