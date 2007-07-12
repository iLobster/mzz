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
 * question: класс для работы c данными
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class question extends simple
{
    protected $name = 'voting';

    public function getAnswers()
    {
        return $this->mapper->getAllAnswers($this->getId());
    }

    public function getVote()
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();
        return $this->mapper->getVote($this->getId(), $user);
    }
}

?>