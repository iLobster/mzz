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

fileLoader::load('voting/voteFolder');

/**
 * voteFolderMapper: маппер
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class voteFolderMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'voting';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'voteFolder';

    public function getFolder()
    {
        $folder = $this->create();
        $folder->import(array('obj_id' => $this->getObjId()));
        return $folder;
    }

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_voteFolder');
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
        $accessMapper = systemToolkit::getInstance()->getMapper('access', 'access');
        $access = $accessMapper->create();
        $access->import(array('obj_id' => $this->getObjId()));
        return $access;
    }
}

?>