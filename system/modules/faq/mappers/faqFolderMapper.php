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

/**
 * faqFolderMapper: маппер
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqFolderMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'faq';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'faqFolder';

    public function getFolder()
    {
        $folder = $this->create();
        $folder->import(array('obj_id' => $this->getObjId()));
        return $folder;
    }

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_faqFolder');
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