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

fileLoader::load('catalogue');

/**
 * catalogueMapper: маппер
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMapper extends simpleCatalogueMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'catalogue';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'catalogue';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    protected function updateDataModify(&$fields)
    {
        //$fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    public function getType($id)
    {
        $type = parent::getType($id);

        $toolkit = systemToolkit::getInstance();
        $path = $toolkit->getSmarty()->template_dir . '/catalogue/types/' . $type['name'] . '.tpl';
        if (!is_writable($path)) {
            throw new mzzIoException($path);
        }

        $type['fulltpl'] = file_get_contents($path);
        return $type;
    }

    public function addType($name, $title, Array $properties, $fulltpl, $lighttpl='')
    {
        $toolkit = systemToolkit::getInstance();
        $path = $toolkit->getSmarty()->template_dir . '/catalogue/types/';
        if (!is_writable($path)) {
            throw new mzzIoException($path);
        }

        file_put_contents($path . $name . '.tpl', $fulltpl);

        parent::addType($name, $title, $properties);
    }

    public function updateType($typeId, $name, $title, Array $properties, $fulltpl)
    {
        $toolkit = systemToolkit::getInstance();
        $path = $toolkit->getSmarty()->template_dir . '/catalogue/types/';
        if (!is_writable($path)) {
            throw new mzzIoException($path);
        }

        file_put_contents($path . $name . '.tpl', $fulltpl);

        parent::updateType($typeId, $name, $title, $properties);
    }

    public function deleteType($type_id)
    {
        $type = $this->getType($type_id);

        $toolkit = systemToolkit::getInstance();
        $path = $toolkit->getSmarty()->template_dir . '/catalogue/types/' . $type['name'] . '.tpl';
        if (!is_writable($path)) {
            throw new mzzIoException($path);
        }

        unlink($path);

        parent::deleteType($type_id);
    }

    public function get404()
    {
        fileLoader::load('catalogue/controllers/catalogue404Controller');
        return new catalogue404Controller();
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
        $item = $this->searchOneByField('id', $args['id']);

        if ($item) {
            return (int)$item->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>