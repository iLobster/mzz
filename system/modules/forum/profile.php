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

    public function __call($name, $args)
    {
        try {
            parent::__call($name, $args);
        } catch (mzzRuntimeException $e) {
            $user = parent::__call('getUser', array());
            return $user->__call($name, $args);
        }
    }

    public function getAuthor()
    {
        $profile = parent::__call('getAuthor', array());
        if (!$profile) {
            $profile = $this->mapper->create();
            $profile->setUser(systemToolkit::getInstance()->getUser());
        }
    }
}

?>