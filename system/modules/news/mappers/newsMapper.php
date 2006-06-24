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
 * @version 0.2
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
     * @return object|false
     */
    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createNewsFromRow($row);
        } else {
            return false;
        }
    }

    /**
     * ��������� ����� �������� �� �������������� �����
     *
     * @param integer $id ������������� �����
     * @return object|false
     */
    public function searchByFolder($folder_id)
    {
        $stmt = $this->searchByField('folder_id', $folder_id);
        $result = array();

        while ($row = $stmt->fetch()) {
            $result[] = $this->createNewsFromRow($row);
        }

        return $result;
    }

    /**
     * ������� ������ news �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createNewsFromRow($row)
    {
        $map = $this->getMap();
        $news = new news($map);
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
            $id = $fields['editor']->getId();
            unset($fields['editor']);
            $fields['editor'] = $id;
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
}

?>