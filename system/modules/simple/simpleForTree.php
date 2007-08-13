<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/simple/simpleForTree.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleForTree.php 996 2007-08-12 21:23:54Z zerkms $
 */

/**
 * simpleForTree: базовый ДО для работы с древовидными структурами
 *
 * @package system
 * @version 0.2
 */
class simpleForTree extends simple
{
    /**
     * Поля со значениями полей из дерева
     *
     * @var arrayDataspace
     */
    protected $treeFields;

    /**
     * Конструктор.
     *
     * @param array $map массив, содержащий информацию о полях
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * Получение уровня, на котором находится элемент.
     *
     * @return integer
     */
    public function getTreeLevel()
    {
        if (!$this->treeFields->exists('id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('level');
    }

    /**
     * Получение id узла в дереве
     *
     * @return integer
     */
    public function getTreeKey()
    {
        if (!$this->treeFields->exists('id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('id');
    }

    /**
     * Получение id дерева
     *
     * @return integer
     */
    public function getTreeId()
    {
        if (!$this->treeFields->exists('tree_id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('tree_id');
    }

    /**
     * Получение предка текущего узла
     *
     * @return simpleForTree
     */
    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this);
    }

    /**
     * Метод для импортирования данных из дерева
     *
     * @param array $data
     */
    public function importTreeFields(Array $data)
    {
        $this->treeFields->import($data);
    }

    /**
     * Экспортирование данных из дерева
     *
     * @return array
     */
    public function exportTreeFields()
    {
        return $this->treeFields->export();
    }

    /**
     * Получение пути до узла
     *
     * @param boolean $simple получить в сокращённом (без корневого элемента) или полном формате
     * @return string
     */
    public function getPath($simple = true)
    {
        $path = $this->__call('getPath', array());

        if ($simple) {
            $rootName = substr($path, 0, strpos($path, '/'));

            if ($rootName && strpos($path, $rootName) === 0 && strlen($path) > strlen($rootName)) {
                $path = substr($path, strlen($rootName) + 1);
            }
        }

        return $path;
    }

    /**
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($level = 1)
    {
        if (!$this->fields->exists('folders')) {
            $folders = $this->mapper->getFolders($this, $level);
            array_shift($folders);
            $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');
    }
}

?>