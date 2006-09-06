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
 * newsMapper: ������ ��� ��������
 *
 * @package news
 * @version 0.2.1
 */

class newsMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'news';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'news';

    /**
     * ������ ���������� �������
     *
     * @var array
     */
    // protected $cacheable = array('searchById');

    /**
     * ������� ������ ������ DO
     *
     * @return object
     */
    public function create()
    {
        return new news($this->getMap());
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
     * ��������� ����� �������� �� �������������� �����
     *
     * @param integer $id ������������� �����
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    /**
     * ������� ������ news �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        $news = new news($map);
/*
        $f = array();
        foreach ($row as $key => $val) {
            $f[$this->className][str_replace($this->className . '_', '', $key)] = $val;
        }
*/
        $news->import($row);
        return $news;
    }

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');

        if ($fields['editor'] instanceof user) {
            $fields['editor'] = $fields['editor']->getId();
        }

        // ����� ��� ��������� "���� ������ - �� �������� ������ �� ������ � ������� ��" ?
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['created'] = new sqlFunction('UNIX_TIMESTAMP');
        $fields['updated'] = $fields['created'];
        if ($fields['editor'] instanceof user) {
            $fields['editor'] = $fields['editor']->getId();
        }
    }

    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>