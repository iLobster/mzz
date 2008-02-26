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

fileLoader::load('user/groupFolder');

/**
 * groupFolderMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class groupFolderMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'groupFolder';

    public function getFolder()
    {
        return $this->convertArgsToObj(array());
    }

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_groupFolder');
        $this->register($obj_id);
        return $obj_id;
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        $obj = $this->create();
        $obj->import(array('obj_id' => $this->getObjId()));
        return $obj;
    }
}

?>