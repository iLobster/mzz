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

fileLoader::load('faq/faqFolder');
fileLoader::load('orm/plugins/acl_extPlugin');
fileLoader::load('orm/plugins/jipPlugin');

/**
 * faqFolderMapper: маппер
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'faqFolder';
    protected $table = 'faq_faqFolder';

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
        $this->attach(new acl_extPlugin(), 'acl');
        $this->attach(new jipPlugin(), 'jip');
    }

    public function getFolder()
    {
        $folder = $this->create();
        $folder->import(array('obj_id' => $this->getObjId()));
        return $folder;
    }

    /**
     * @todo remove this method (acl registeration from mapper)
     *
     * @return unknown
     */
    private function getObjId()
    {
        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId($this->class . '_faqFolder');
        $acl = new acl($toolkit->getUser());
        $acl->register($obj_id, $this->class, 'faq');
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