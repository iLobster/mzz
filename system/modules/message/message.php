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
 * message: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class message extends simple
{
    protected $name = 'message';

    public function getAcl($name = null)
    {
        if ($name == 'view' || $name == 'delete') {
            $user_id = ($this->getCategory()->getName() == 'sent') ? $this->getSender()->getId() : $this->getRecipient()->getId();
            return $user_id == systemToolkit::getInstance()->getUser()->getId();
        }

        return parent::getAcl($name);
    }
}

?>