<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * group: класс для работы с группами пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class group extends simple
{
    protected $name = 'user';

    public function getUsersCount()
    {
        return $this->mapper->getUsersCount($this);
    }
}

?>