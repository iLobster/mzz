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

    public function convertArgsToId($args)
    {
        $news = $this->searchOneByField('id', $args['id']);

        if ($news) {
            return (int)$news->getObjId();
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