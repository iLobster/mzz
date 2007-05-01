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
 * pageFolder: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */
class pageFolder extends simpleForTree
{
    protected $name = 'page';

    /**
     * �����������
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
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($level = 1)
    {
        if (!$this->fields->exists('folders')) {
            $folders = $this->mapper->getFolders($this->getParent(), $level);
            array_shift($folders);
            $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');
    }

    /**
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this->getParent());
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>