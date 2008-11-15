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

    public function getBirthdayDay()
    {
        $birthday = $this->getBirthday();
        if (empty($birthday)) {
            return null;
        }
        return date("d", strtotime($birthday));
    }

    public function getBirthdayMonth()
    {
        $birthday = $this->getBirthday();
        if (empty($birthday)) {
            return null;
        }
        return date("m", strtotime($birthday));
    }

    public function getBirthdayYear()
    {
        $birthday = $this->getBirthday();
        if (empty($birthday)) {
            return null;
        }
        return date("Y", strtotime($birthday));
    }

    public function setBirthday($value)
    {
        if (empty($value)) {
            return null;
        }
        if (is_array($value)) {
            $value = $value['year'] . '-' . $value['month'] . '-' . $value['day'];
        }
        parent::setBirthday($value);
    }
}

?>