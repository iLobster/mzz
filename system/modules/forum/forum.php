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
 * forum: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forum extends simple
{
    protected $name = 'forum';

    public function getAcl($name = null)
    {
        $access = parent::getAcl($name);

        if ($name == 'newThread' && $access) {
            $access = $this->getAcl('list');
        }

        return $access;
    }
}

?>