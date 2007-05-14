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
 * @version 0.1.6
 */

abstract class simpleMapperForTree extends simpleMapper
{
    protected $init;

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
        $removedFolders = (array) $this->tree->getBranch($id);
        foreach ($removedFolders as $folder) {
            $items = (array) $folder->getItems();
            foreach ($items as $item) {
                $mapper->delete($item->getId());
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

        $criterion = new criterion('tree2.lkey', 'tree.lkey', criteria::GREATER, true);
        $criterion->addAnd(new criterion('tree2.rkey', 'tree.rkey', criteria::LESS, true));
        $criterion->addAnd(new criterion('tree2.level', new sqlOperator('+', array('tree.level', 1)), criteria::LESS_EQUAL));

        $criteria = new criteria();
        $criteria->clearSelectFields()->addSelectField('tree2.*')->addSelectField('data2.*');
        $criteria->addJoin($this->init['treeTable'], $criterion, 'tree2', criteria::JOIN_INNER);
        $criteria->addJoin($this->table, new criterion('data2.' . $this->init['joinField'], 'tree2.id', criteria::EQUAL, true), 'data2', criteria::JOIN_INNER);
        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER_EQUAL);
        $criteria->setOrderByFieldAsc('tree2.lkey');
        $criteria->addGroupBy('tree2.id');

        return $this->tree->searchByCriteria($criteria);
    }

    public function move($folder, $destFolder)
    {
        return $this->tree->moveNode($folder->getParent(), $destFolder->getParent());
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
