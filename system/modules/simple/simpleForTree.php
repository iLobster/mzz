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
 * @version $Id: simpleForTree.php 704 2007-03-14 05:13:23Z zerkms $
 */

/**
 * simpleForTree
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.1
 */

class simpleForTree extends simple
{
    /**
     * ���� �� ���������� ����� �� ������
     *
     * @var arrayDataspace
     */
    protected $treeFields;

    /**
     * �����������.
     *
     * @param array $map ������, ���������� ���������� � �����
     */
    public function __construct(Array $map)
    {
        parent::__construct($map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * ������������ ����� �������� ��� ���������� �����
     *
     * @return array
     */
    public function & exportTreeFields()
    {
        return $this->treeFields->export();
    }

    /**
     * ����� ��������� ������, �� ������� ��������� �������.
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->treeFields->get('level');
    }

    /**
     * ����� ��������� ������� ����� ���� ������
     *
     * @return integer
     */
    public function getRightKey()
    {
        return $this->treeFields->get('rkey');
    }

    /**
     * ����� ��������� ������ ����� ���� ������
     *
     * @return integer
     */
    public function getLeftKey()
    {
        return $this->treeFields->get('lkey');
    }

    /**
     * ����� ��������� �������� ������, �� ������� ��������� �������.
     *
     * @return integer
     */
    public function setLevel($value)
    {
        $this->treeFields->set('level', $value);
    }

    /**
     *  ����� ��������� �������� ������� ����� ���� ������
     *
     * @return integer
     */
    public function setRightKey($value)
    {
        $this->treeFields->set('rkey', $value);
    }

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
     * ����� ��������� �������� ������ ����� ���� ������
     *
     * @return integer
     */
    public function setLeftKey($value)
    {
        $this->treeFields->set('lkey', $value);
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($level = 1)
    {
        if (!$this->fields->exists('folders')) {
            $folders = $this->mapper->getFolders($this->getParent(), $level);
            array_shift($folders);
            $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');
    }
}

?>