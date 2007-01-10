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
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */

fileLoader::load('page');

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
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|null
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function convertArgsToId($args)
    {
        if (isset($args['id']) && !isset($args['name'])) {
            $args['name'] = $args['id'];
        }
        $page = $this->searchOneByField('name', $args['name']);
        return (int)$page->getObjId();
    }
}

?>