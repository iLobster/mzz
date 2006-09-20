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

class newsFolder extends simple
{
    /**
     * Mapper
     *
     * @var object
     */
    private $mapper;

    /**
     * ���������� ������
     *
     * @var array
     */
    //protected $cacheable = array('getItems', 'getFolders');

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
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders()
    {
        if (!$this->fields->exists('folders')) {
            $this->fields->set('folders', $this->mapper->getFolders($this->getId()));
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
     * ��������� ������� �������� � �������
     *
     * @param pager $pager
     */
    public function setPager($pager)
    {
        $this->mapper->setPager($pager);
    }
}

?>