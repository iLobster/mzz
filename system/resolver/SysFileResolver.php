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
 * SysFileResolver: резолвит файлы из папки с системой (SYSTEM_DIR)
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class SysFileResolver extends FileResolver
{
    /**
     * конструктор
     * 
     * @access public
     */
    public function __construct()
    {
        parent::__construct(SystemConfig::$pathToSystem . '*');
    }
}

?>