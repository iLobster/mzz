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
 * iCacheable: интерфейс кэшируемого объекта
 *
 * @package system
 * @version 0.1
 */

interface iCacheable
{
    public function injectCache($cache);
}

?>