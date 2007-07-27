<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('simple/new_simpleForTree');

/**
 * newsFolder: newsFolder
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */

class newsFolder extends new_simpleForTree
{
    protected $name = 'news';

    /**
     * Конструктор
     *
     * @param object $mapper
     * @param array $map
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($level = 1, $withSameNode = false)
    {
        if (!$this->fields->exists('folders')) {
            $folders = $this->mapper->getFolders($this, $level);
            if (!$withSameNode) {
                array_shift($folders);
            }
            $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');
    }

    public function getTreeForMenu()
    {
        return $this->mapper->getTreeForMenu($this->getParent());
    }

    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this);
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>