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
 * fileMapper: маппер
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.3
 */

class fileMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'fileManager';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'file';

    /**
     * Выполняет поиск объектов по идентификатору папки
     *
     * @param integer $id идентификатор папки
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

    public function getExclusionExtensions()
    {
        return array('tar.gz', 'tar.bz2');
    }

    public function searchByPath($path)
    {
        $path = urldecode($path);

        if (strpos($path, '/') !== false) {
            $folderName = substr($path, 0, strrpos($path, '/'));
            $pagename = substr(strrchr($path, '/'), 1);

            $toolkit = systemToolkit::getInstance();
            $folderMapper = $toolkit->getMapper('fileManager', 'folder', $this->section);

            $folder = $folderMapper->searchByPath($folderName);

            if (!is_null($folder)) {
                $criteria = new criteria();
                $criteria->add('name', $pagename)->add('folder_id', $folder->getId());
                return $this->searchOneByCriteria($criteria);
            }
        }

        return null;
    }

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        if (isset($fields['name']) && !isset($fields['ext'])) {
            $fields['ext'] = '';
            if (($dot = strrpos($fields['name'], '.')) !== false) {
                $fields['ext'] = substr($fields['name'], $dot + 1);
            }
        }
    }

    public function delete($id)
    {
        $file = $this->searchById($id);

        if ($file && file_exists($file = $file->getUploadPath() . DIRECTORY_SEPARATOR . $file->getRealname())) {
            unlink($file);
        }

        parent::delete($id);
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $this->updateDataModify($fields);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
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
        if ($file) {
            return (int)$file->getObjId();
        }

        throw new mzzDONotFoundException();
    }

    public function get404()
    {
        return new messageController('Запрашиваемый вами файл не найден', messageController::WARNING);
        //fileLoader::load('fileManager/controllers/fileManager404Controller');
        //return new fileManager404Controller('file');
    }
}

?>
