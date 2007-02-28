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

fileLoader::load('page');

/**
 * pageMapper: маппер для страниц
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */
class pageMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'page';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'page';

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

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

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
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

        if (strpos($args['name'], '/') !== false) {
            $toolkit = systemToolkit::getInstance();
            $pageFolderMapper = $toolkit->getMapper('page', 'pageFolder');

            $folder = substr($args['name'], 0, strrpos($args['name'], '/'));
            $pagename = substr(strrchr($args['name'], '/'), 1);

            $pageFolder = $pageFolderMapper->searchByPath($folder);

            $criteria = new criteria();
            $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
            $page = $this->searchOneByCriteria($criteria);
        }

        if (!isset($page)) {
            $page = $this->searchOneByField('name', $args['name']);
        }

        if ($page) {
            return (int)$page->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>