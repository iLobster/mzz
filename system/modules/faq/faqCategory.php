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
 * faqCategory: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqCategory extends simple
{
    protected $name = 'faq';

    public function getAnswers()
    {
        return $this->mapper->getAnswers($this->getId());
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getName(), get_class($this));
    }
}

?>