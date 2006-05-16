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
 * @package news
 * @version 0.1
 */

class newsFolder extends simple
{
    private $mapper;

    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        parent::__construct($map);
    }


    public function getFolders()
    {
        // ����� ��� ��� �� ������� "�����������" ? � �� ��� ������� ������ ->getFolders() ������ ����� ������� ���� ������.. �������� ������ ���� ����� ����� �������� ����� ������ � ������ �������� - �� ����� ��, ���� ���������� ��� - ����� ������� �����������?
        if (!$this->fields->exists('folders')) {
            $this->fields->set('folders', $this->mapper->getFolders($this->getId()));
        }
        return $this->fields->get('folders');
    }

    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }
}

?>