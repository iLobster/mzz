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
 * post: класс для работы c данными
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class post extends entity
{
    protected $module = 'forum';

    public function getAcl($name = null)
    {
        if ($name == 'edit') {
            if (systemToolkit::getInstance()->getUser()->getId() == $this->getAuthor()->getId()) {
                return true;
            }
        }

        return parent::__call('getDefaultAcl', array($name));
    }
}

?>