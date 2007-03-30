<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('simple/simpleForTree');

/**
 * catalogueFolder: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueFolder extends simpleForTree
{
    protected $name = 'catalogue';
    protected $mapper;

    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        parent::__construct($map);
        $this->treeFields = new arrayDataspace();
    }

    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    public function getTreeForMenu()
    {
        return $this->mapper->getTreeForMenu($this->getParent());
    }

    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this->getParent());
    }

    public function setPager($pager)
    {
        $this->mapper->setPager($pager);
    }

    public function removePager()
    {
        $this->mapper->removePager();
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>