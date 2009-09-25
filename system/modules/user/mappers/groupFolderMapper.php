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

fileLoader::load('user/model/groupFolder');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * groupFolderMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class groupFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'groupFolder';
    protected $table = 'user_groupFolder';
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
    }

    public function getFolder()
    {
        return $this->convertArgsToObj(array());
    }

    private function getObjId()
    {
        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId($this->class);
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
        $obj->merge(array('obj_id' => $this->getObjId()));
        return $obj;
    }
}

?>