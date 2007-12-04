<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * config: класс для работы c данными
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class config extends simpleCatalogue
{
    protected $name = 'admin';

    public function getObjId()
    {
        return $this->mapper->getObjId();
    }
}

?>