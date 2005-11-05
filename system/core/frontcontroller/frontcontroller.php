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
    /**#@+
    * @access private
    * @var string
    */

    /**
    * ���������� ��� �������� ����� ������
    */
    private $module = null;

    /**
    * ���������� ��� �������� ����� �����
    */
    private $action = null;
    /**#@-*/


    /**
     * ����������� ������
     *
     * @access public
     * @param string $module ��� ������
     * @param string $action ��� �����
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
     * @param string $module ��� ������
     */
    private function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * ��������� ������
     *
     * @access private
     * @return string ��� ������
     */
    private function getModule()
    {
        return $this->module;
    }

    /**
     * ��������� �����
     *
     * @access private
     * @param $action ��� �����
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * ��������� �����
     *
     * @access private
     * @return string ��� �����
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * ��������� ����� �������
     *
     * @access public
     * @return string ��� ������� � ������������ � ���������� ������� � ������
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * ����� ����� ������� �� ����� ������ � �����
     *
     * @access private
     * @return string ��� ������� � ������������ � ���������� ������� � ������
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