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

fileLoader::load('page/pageFolder');
fileLoader::load('simple/simpleMapperForTree');

/**
 * pageFolderMapper: маппер
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */

class pageFolderMapper extends simpleMapperForTree
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
    protected $className = 'pageFolder';

    protected $itemName = 'page';

    /**
     * Возвращает Доменный Объект, который обслуживает запрашиваемый маппер
     *
     * @return object
     */
    public function create()
    {
        $map = $this->getMap();
        return new pageFolder($this, $map);
    }

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }
    /**
     * Метод поиска страницы в каталоге
     *
     * @param string $name
     * @return page|null
     */
    public function searchChild($name)
    {
        $toolkit = systemToolkit::getInstance();
        $pageMapper = $toolkit->getMapper('page', 'page');

        if (strpos($name, '/') === false) {
            $name = 'root/' . $name;
        }

        $folder = substr($name, 0, strrpos($name, '/'));
        $pagename = substr(strrchr($name, '/'), 1);

        $pageFolder = $this->searchByPath($folder);

        $criteria = new criteria();
        $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
        $page = $pageMapper->searchOneByCriteria($criteria);

        return $page;
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = 'root';
        }

        $pageFolder = $this->searchByPath($args['name']);
        if ($pageFolder) {
            return $pageFolder;
        }

        throw new mzzDONotFoundException();
    }
}

?>