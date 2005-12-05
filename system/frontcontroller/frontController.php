<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
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

        $mapper = new sectionMapper($section, $action);

        $registry = Registry::instance();
        $config = $registry->getEntry('config');
        $config->load('common');

        if (($template = $mapper->getTemplateName()) === false) {
            $section = $config->getOption('main', 'default_section');
            $action = $config->getOption('main', 'default_action');
            $mapper = new sectionMapper($section, $action);
            return $mapper->getTemplateName();
        }

        return $template;
    }
}

?>