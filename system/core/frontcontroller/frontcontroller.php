<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under 
// the GNU/GPL License (See /docs/GPL.txt).
// 

/* ��������������� ������� */

class frontController
{
    // ���������� ��� �������� ����� ������
    private $module = null;

    // ���������� ��� �������� ����� �����
    private $action = null;


    /**
     * Private constructor
     *
     * @access public
     */
    public function __construct($module, $action)
    {
        $this->setModule($module);
        $this->setAction($action);
    }

    /**
     * ��������� ������
     *
     * @access private
     */
    private function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * ��������� ������
     *
     * @access private
     */
    private function getModule()
    {
        return $this->module;
    }

    /**
     * ��������� �����
     *
     * @access private
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * ��������� �����
     *
     * @access private
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * ��������� ����� �������
     *
     * @access public
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * ����� ����� ������� �� ����� ������ � �����
     *
     * @access private
     */
    private function search()
    {
        $module = $this->getModule();
        $action = $this->getAction();

        if (empty($module)) {
            die('������ �� ������');
        }

        if (empty($action)) {
            die('���� �� ������');
        }

        // � ������� ������ ������ ��������� �����-������ ����������
        // �������� ��
        $arr = array(
        'news' => array(
        'list' => 'news.list.tpl',
        'view' => 'news.view.tpl'
        )
        );

        if (!isset($arr[$module][$action])) {
            die('� ������ ' . $module . ' ��� ����� ' . $action);
        }

        return $arr[$module][$action];
    }
}

?>