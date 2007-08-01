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
 * voteCategory: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class voteCategory extends simple
{
    protected $name = 'voting';

    public function getQuestions()
    {
        return $this->mapper->getQuestions($this->getId());
    }

    public function getActual()
    {
        return $this->mapper->getActual($this->getId());
    }
}

?>