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
 * @version 0.1
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
        return $this->tree->getParentBranch($id, 999);
    }
}

?>