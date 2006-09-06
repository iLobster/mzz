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

class relateMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'relate';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'relate';

    /**
     * ������� ������ ������ DO
     *
     * @return object
     */
    public function create()
    {
        return new relate($this->getMap());
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
     * ������� ������ page �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        $relate = new relate($map);
        $relate->import($row);
        return $relate;
    }
}

?>