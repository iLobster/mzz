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
 * thread: класс для работы c данными
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class thread extends simple
{
    protected $name = 'forum';

    public function getAcl($name = null)
    {
        $access = parent::getAcl($name);

        if ($access) {
            if ($name == 'thread' || $name == 'last') {
                $access = $this->getForum()->getAcl('list');
            } elseif ($name == 'post') {
                $access = $this->getAcl('thread');
            }
        }

        return $access;
    }
}

?>