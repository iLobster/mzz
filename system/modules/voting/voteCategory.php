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
 * voteCategory: класс для работы c данными
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class voteCategory extends simple
{
    protected $name = 'voting';

    public function getActual()
    {
        return $this->mapper->getActual($this);
    }

    public function getLast()
    {
        return $this->mapper->getLast($this);
    }
}

?>