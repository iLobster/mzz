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

fileLoader::load('relate/related');

class relatedMapper extends simpleMapper
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
    protected $className = 'related';

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
     * ������� ������ page �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        $related = new related($map);
        $related->import($row);
        return $related;
    }
}

?>