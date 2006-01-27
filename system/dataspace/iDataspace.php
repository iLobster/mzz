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
 * iDataspace: интерфейс Dataspace
 *
 * @package system
 * @version 0.1
 */
interface iDataspace
{
    public function set($key, $value);
    public function get($key);
    public function delete($key);
    public function exists($key);
}
?>