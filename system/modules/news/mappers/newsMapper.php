<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('news');

/**
 * newsMapper: ������ ��� ��������
 *
 * @package modules
 * @subpackage news
 * @version 0.2.2
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
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');
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
    }

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_searchByTag');
        $this->register($obj_id);
        return $obj_id;
    }

    public function convertArgsToObj($args)
    {
        if(isset($args['id'])) {
            $news = $this->searchByKey($args['id']);
            if ($news) {
                return $news;
            }
        }

        $action = systemToolkit::getInstance()->getRequest()->getRequestedAction();

        if($action == 'searchByTag') {
            $obj = $this->create();
            $obj->import(array('obj_id' => $this->getObjId()));
            return $obj;
        }

        throw new mzzDONotFoundException();
    }

    public function get404()
    {
        fileLoader::load('news/controllers/news404Controller');
        return new news404Controller();
    }
}

?>