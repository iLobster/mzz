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
 * catalogueFolder: класс для работы c данными
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueFolder extends simpleForTree
{
    protected $name = 'catalogue';

    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    public function getTreeForMenu()
    {
        return $this->mapper->getTreeForMenu($this);
    }

    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this);
    }

    public function setPager($pager)
    {
        $this->mapper->setPager($pager);
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>