<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('config/configFolder');

/**
 * configFolderMapper: маппер
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configFolderMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'config';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'configFolder';

    protected $obj_id_field = null;

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = 'sys_modules';
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function getOptions(configFolder $folder)
    {
        $configFolderMapper = systemToolkit::getInstance()->getMapper('config', 'configOption', $this->section);
        return $configFolderMapper->searchAllByModuleName($folder->getName());
    }

    public function save($object, $user = null)
    {
    }

    private function generateObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_' . $this->className);
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
        $obj = $this->create();
        $obj->import(array('obj_id' => $this->generateObjId()));
        return $obj;
    }
}

?>