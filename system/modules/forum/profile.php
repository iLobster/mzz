<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * profile: класс для работы c данными
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class profile extends simple
{
    protected $name = 'forum';

    public function getId()
    {
        $user = parent::__call('getUser', array());

        if ($user) {
            return $user->getId();
        }

        return false;
    }

    public function getObjId()
    {
        return $this->mapper->getObjId();
    }

    /*
    public function __call($name, $args)
    {
        try {
            parent::__call($name, $args);
        } catch (mzzRuntimeException $e) {
            $user = parent::__call('getUser', array());
            if ($user) {
                return $user->__call($name, $args);
            }
        }
    }
    */

    public function getAcl($name = null)
    {
        if ($name == 'editProfile') {
            if (systemToolkit::getInstance()->getUser()->getId() == $this->getId()) {
                return true;
            }
        }

        $access = parent::getAcl($name);
        return $access;
    }

    public function getBirthday($format = null)
    {
        $birthday = parent::getBirthday();
        if (empty($birthday)) {
            return null;
        }
        if (empty($format)) {
            return $birthday;
        }
        return date($format, strtotime($birthday));
    }

    public function setBirthday($value)
    {
        if (is_array($value) && !empty($value['year'])) {
            $value = $value['year'] . '-' . $value['month'] . '-' . $value['day'];
        } elseif (is_array($value)) {
            $value = null;
        }

        parent::setBirthday($value);
    }
}

?>