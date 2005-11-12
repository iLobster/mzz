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
 * Фабрика конфигурации
 *
 * @package system
 * @version 0.1
 */
class configFactory
{
    /**
     * Singleton
     *
     * @staticvar
     * @var object
     * @access private
     */
    private static $instance;

    /**
     *
     * @access public
     * @return object
     */
	public function getInstance()
	{
		if ( !isset( $instance ) ) {
		    fileResolver::includer('config');
			$instance = new config();
		}
		return $instance;
	}
}

?>