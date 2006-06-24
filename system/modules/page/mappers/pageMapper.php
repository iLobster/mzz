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
 * pageMapper: ������ ��� �������
 *
 * @package page
 * @version 0.2.1
 */

class pageMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'page';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'page';

    /**
     * ������ ���������� �������
     *
     * @var array
     */
    protected $cacheable = array('searchByName');

    /**
     * ������� ������ ������ DO
     *
     * @return object
     */
    public function create()
    {
        return new page($this->getMap());
    }

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|null
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    /**
     * ������� ������ page �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        $page = new page($map);
        $page->import($row);
        return $page;
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }

    /**
     * Magic method __wakeup
     *
     * @return array
     */
    public function __wakeup()
    {
    }
}

?>