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
 * configFactory: фабрика конфигурации
 *
 * @package system
 * @version 0.2
 */
class configFactory
{
    /**
     * Singleton
     *
     * @static
     * @var object
     * @access private
     */
    private static $instance;

    /**
     *
     * @access public
     * @static
     * @return object
     */
    public static function getInstance()
    {
        if ( !isset( $instance ) ) {
            //fileResolver::includer('config');
            fileLoader::load('config');
            $instance = new config();
        }
        return $instance;
    }
}

?>