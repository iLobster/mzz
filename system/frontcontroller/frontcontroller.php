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

/**
 * frontController: ��������������� �������
 * 
 * @package system
 * @version 0.1
 */

class frontController
{
    /**#@+
    * @access private
    * @var string
    */

    /**
    * ���������� ��� �������� ����� ������
    */
    private $section = null;

    /**
    * ���������� ��� �������� ����� �����
    */
    private $action = null;
    /**#@-*/


    /**
     * ����������� ������
     *
     * @access public
     * @param string $section ��� ������
     * @param string $action ��� �����
     */
    public function __construct($section, $action)
    {
        $this->setSection($section);
        $this->setAction($action);
    }

    /**
     * ��������� ������
     *
     * @access private
     * @param string $section ��� ������
     */
    private function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * ��������� ������
     *
     * @access private
     * @return string ��� ������
     */
    private function getSection()
    {
        return $this->section;
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
        $section = $this->getSection();
        $action = $this->getAction();

        if (empty($section)) {
            die('������ �� �������');
        }

        if (empty($action)) {
            die('���� �� ������');
        }

        // � ������� ������ ������ ��������� �����-������ ����������
        // �������� ��
        $arr = array(
        'news' => array(
        'list' => 'act.news.list.tpl',
        'view' => 'act.news.view.tpl'
        )
        );

        if (!isset($arr[$section][$action])) {
            die('� ������ ' . $section . ' ��� ����� ' . $action);
        }

        return $arr[$section][$action];
    }
}

?>