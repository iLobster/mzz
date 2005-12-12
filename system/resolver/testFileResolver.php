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
 * testFileResolver: �������� ����� �� ����� � �������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class testFileResolver extends fileResolver
{
    /**
     * �����������
     *
     */
    public function __construct()
    {
        parent::__construct(systemConfig::$pathToApplication  . '*');
    }
}

?>