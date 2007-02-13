<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/
fileLoader::load('fileManager/file');
/**
 * fileMapper: ������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */
class fileMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'fileManager';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'file';

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

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByPath($path)
    {
        $path = urldecode($path);

        if (strpos($path, '/') !== false) {
            $folder = substr($path, 0, strrpos($path, '/'));
            $pagename = substr(strrchr($path, '/'), 1);

            $criteria = new criteria();
            $criteria->add('name', $pagename)->add('folder_id.path', $folder);
            return $this->searchOneByCriteria($criteria);
        }

        return null;
    }

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        if (isset($fields['name'])) {
            $fields['ext'] = '';
            if (($dot = strrpos($fields['name'], '.')) !== false) {
                $fields['ext'] = substr($fields['name'], $dot + 1);
            }
        }
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $this->updateDataModify($fields);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        if (isset($args['id']) && !isset($args['name'])) {
            $args['name'] = $args['id'];
        }

        $file = $this->searchByPath($args['name']);

        if (!isset($file)) {
            $file = $this->searchOneByField('name', $args['name']);
        }
        return (int)$file->getObjId();
    }
}

?>