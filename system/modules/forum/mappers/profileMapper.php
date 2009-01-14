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

fileLoader::load('forum/profile');

/**
 * profileMapper: маппер
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class profileMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'forum';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'profile';

    protected $tableKey = 'user_id';

    protected $obj_id_field = null;

    public function searchById($id)
    {
        $userMapper = systemToolkit::getInstance()->getMapper('user', 'user', 'user');
        $user = $userMapper->searchByKey($id);

        if (!$user) {
            throw new mzzDONotFoundException();
        }
        return $this->searchByUser($user);
    }

    public function searchByUser(user $user)
    {
        $profile = $this->searchByKey((int)$user->getId());

        if (!$profile) {
            $profile = $this->createNewProfile($user);
        }

        return $profile;
    }

    public function createNewProfile(user $user)
    {
        $profile = $this->create();
        $profile->setUser($user);
        $profile->setMessages(0);
        $profile->setSignature('');

        $this->save($profile, $user);

        return $profile;
    }

    public function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_profile');
        $this->register($obj_id);
        return $obj_id;
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        if (!isset($args['id'])) {
            $toolkit = systemToolkit::getInstance();
            $args['id'] = $toolkit->getUser()->getId();
        }
        $do = $this->searchById($args['id']);

        if ($do) {
            return $do;
        }
        throw new mzzDONotFoundException();
    }
}

?>