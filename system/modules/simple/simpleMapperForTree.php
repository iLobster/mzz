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

/**
 * simpleMapperForTree: маппер
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.5
 */

abstract class simpleMapperForTree extends simpleMapper
{
    public function save($object, $target = null)
    {
        $data = $object->export();

        $result = parent::save($object);

        if ($target) {
            $this->createSubfolder($object, $target);
        } else {
            if (sizeof($data)) {
                $this->tree->updatePaths($object);
            }
        }

        return $result;
    }

    /**
     * Создание подпапки
     *
     * @param  simpleForTree     $folder          Папка для добавления
     * @param  simpleForTree     $targetFolder    Папка назначения, в которую добавлять
     * @return simpleForTree
     */
    public function createSubfolder($folder, $targetFolder)
    {
        $idParent = $targetFolder->getParent();
        return $this->tree->insertNode($idParent, $folder);
    }

    /**
     * Удаление папки вместе с содежимым на основе id
     * не delete потому что delete используется в tree для удаления записи
     *
     * @param string $id идентификатор <b>узла дерева</b> (parent) удаляемого элемента
     * @return void
     */
    public function remove($id)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $mapper = $toolkit->getMapper($this->name, $this->itemName);
        //$pageFolderMapper = $toolkit->getMapper('page', 'pageFolder');

        // @toDo как то не так
        $removedFolders = $this->tree->getBranch($id);
        if(count($removedFolders)) {
            foreach($removedFolders as $folder) {
                $items = $folder->getItems();
                if(count($items)) {
                    foreach($items as $item) {
                        $mapper->delete($item->getId());
                    }
                }
            }
        }

        $this->tree->removeNode($id);
    }

    public function getPath($id)
    {
        return $this->tree->getParentBranch($id, false);
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        return $this->tree->getBranch($id, $level);
    }

    public function getTreeForMenu($id)
    {
        $node = $this->tree->getNodeInfo($id);

        $criterionLevel2 = new criterion('tree.level', 2);

        if ($node['level'] != 1) {
            $parent = $this->tree->getNodeInfo($this->tree->getParentNode($id));

            $criterionSameLevel = new criterion('tree.level', $node['level']);
            $criterionSameLevel->addAnd(new criterion('tree.lkey', $parent['lkey'], criteria::GREATER));
            $criterionSameLevel->addAnd(new criterion('tree.rkey', $parent['rkey'], criteria::LESS));
            $criterionLevel2->addOr($criterionSameLevel);

            $criterionPath = new criterion('tree.lkey', $node['rkey'], criteria::LESS);
            $criterionPath->addAnd(new criterion('tree.rkey', $node['lkey'], criteria::GREATER));
            $criterionPath->addAnd(new criterion('tree.level', $node['level'] + 1, criteria::LESS_EQUAL));
            $criterionLevel2->addOr($criterionPath);
        } else {
            $criterionRoot = new criterion('tree.level', 1);
            $criterionLevel2->addOr($criterionRoot);
        }

        $criteria = new criteria();
        $criteria->add($criterionLevel2);
        $criteria->setOrderByFieldAsc('tree.lkey');

        return $this->tree->searchByCriteria($criteria);
    }

    public function move($folder, $destFolder)
    {
        return $this->tree->moveNode($folder, $destFolder);
    }

    public function getTreeParent($id)
    {
        return $this->tree->getParentNode($id);
    }

    public function getTreeExceptNode($folder)
    {
        $tree = $this->tree->getTree();

        $subfolders = $this->tree->getBranch($folder);

        foreach (array_keys($subfolders) as $val) {
            unset($tree[$val]);
        }

        return $tree;
    }

    public function getTree()
    {
        return $this->tree->getTree();
    }

    /**
     * Выборка папки на основе пути
     *
     * @param string $path Путь
     * @param string $deep Глубина выборки
     * @return array with nodes
     */
    public function searchByPath($path)
    {
        return $this->tree->getNodeByPath($path);
    }
}

?>