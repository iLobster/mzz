<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/simple/simpleForTree.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleForTree.php 580 2007-02-13 05:16:03Z zerkms $
 */

/**
 * simpleForTree
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
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
    public function __construct(Array $map)
    {
        parent::__construct($map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * Экспортирует новые значения для измененных полей
     *
     * @return array
     */
    public function & exportTreeFields()
    {
        return $this->treeFields->export();
    }

    /**
     * Метод получения уровня, на котором находится элемент.
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->treeFields->get('level');
    }

    /**
     * Метод получения правого ключа узла дерева
     *
     * @return integer
     */
    public function getRightKey()
    {
        return $this->treeFields->get('rkey');
    }

    /**
     * Метод получения левого ключа узла дерева
     *
     * @return integer
     */
    public function getLeftKey()
    {
        return $this->treeFields->get('lkey');
    }

    /**
     * Метод установки значения уровня, на котором находится элемент.
     *
     * @return integer
     */
    public function setLevel($value)
    {
       $this->treeFields->set('level', $value);
    }

    /**
     *  Метод установки значения правого ключа узла дерева
     *
     * @return integer
     */
    public function setRightKey($value)
    {
        $this->treeFields->set('rkey', $value);
    }

    /**
     * Метод установки значения левого ключа узла дерева
     *
     * @return integer
     */
    public function setLeftKey($value)
    {
        $this->treeFields->set('lkey', $value);
    }
}

?>