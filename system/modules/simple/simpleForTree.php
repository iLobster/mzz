<?php

//
// $Id: simple.php 1105 2006-11-07 08:22:14Z jonix $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/simple/simple.php $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
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

    /**
     * ����� ��������� �������� ������ ����� ���� ������
     *
     * @return integer
     */
    public function setLeftKey($value)
    {
        $this->treeFields->set('lkey', $value);
    }

}

?>