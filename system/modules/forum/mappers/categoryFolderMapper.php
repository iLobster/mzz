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

fileLoader::load('forum/categoryFolder');

/**
 * categoryFolderMapper: ������
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class categoryFolderMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'forum';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'categoryFolder';

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_forumCategoryFolder');
        $this->register($obj_id);
        return $obj_id;
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
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