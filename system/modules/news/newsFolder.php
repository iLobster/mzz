<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * newsFolder: newsFolder
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

fileLoader::load('simple/simpleForTree');

class newsFolder extends simpleForTree
{
    /**
     * Mapper
     *
     * @var object
     */
    private $mapper;

    protected $name = 'news';

    /**
     * �����������
     *
     * @param object $mapper
     * @param array $map
     */
    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        parent::__construct($map);
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
            $this->fields->set('folders', $this->mapper->getFolders($this->getParent(), $level));
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

    /**
     * ������� ���������� �����
     *
     * @return array
     * @toDo ���� newsMapper �����������, � ���� �� ���?
     */
/*    public function removeContents()
    {
        $items = $this->getItems();
        $this->fields->set('items', null);

        foreach($items as $item) {
            $this->mapper->delete($item->getId());
        }
    }*/

    /**
     * ��������� ������� �������� � �������
     *
     * @param pager $pager
     */
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