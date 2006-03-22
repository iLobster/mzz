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
 * iToolkit: интерфейс Toolkit
 *
 * @package system
 * @version 0.1
 */
interface iToolkit
{

    /**
     * Возвращает toolkit
     *
     * @param string $toolName
     * @return object|false
     */
    public function getToolkit($toolName);
}
?>