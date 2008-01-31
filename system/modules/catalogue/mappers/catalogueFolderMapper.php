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

fileLoader::load('db/dbTreeNS');
fileLoader::load('simple/simpleMapperForTree');
fileLoader::load('catalogue/catalogueFolder');

/**
 * catalogueFolderMapper: маппер
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1.1
 */

class catalogueFolderMapper extends simpleMapperForTree
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
    protected $className = 'catalogueFolder';

    protected $itemName = 'catalogue';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
    }

    public function searchByName($name)
    {
        if (empty($name)) {
            $name = 'root';
        }
        return $this->searchOneByField('name', $name);
    }

    public function create()
    {
        $map = $this->getMap();
        return new catalogueFolder($this, $map);
    }

    public function getFoldersByPath($path, $deep = 1)
    {
        // выбирается только нижележащий уровень
        return $this->tree->getBranchByPath($path, $deep);
    }

    public function convertArgsToObj($args)
    {
        if (isset($args['name'])) {
            $folder = $this->searchByPath($args['name']);

            if ($folder) {
                return $folder;
            }
        }

        throw new mzzDONotFoundException();
    }
}

?>