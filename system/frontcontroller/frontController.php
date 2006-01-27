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
     * @param string $section ��� ������
     */
    private function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * ��������� ������
     *
     * @return string ��� ������
     */
    private function getSection()
    {
        return $this->section;
    }

    /**
     * ��������� �����
     *
     * @param $action ��� �����
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * ��������� �����
     *
     * @return string ��� �����
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * ��������� ����� �������
     *
     * @return string ��� ������� � ������������ � ���������� ������� � ������
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * ����� ����� ������� �� ����� ������ � �����
     *
     * @return string ��� ������� � ������������ � ���������� ������� � ������
     */
    private function search()
    {
       // $section = $this->getSection();
      //  $action = $this->getAction();
        $toolkit = systemToolkit::getInstance();
       $sectionMapper = $toolkit->getSectionMapper();
		/* // ��..... ��� �������� �� ����� ������ ��� ���� ������������ ������� / -> /news/list ����� ������ .htaccess??
        if (($template = $sectionMapper->getTemplateName($section, $action)) === false) {
            $config = $toolkit->getConfig();
            $request = $toolkit->getRequest();

            $config->load('common');

            $section = $config->getOption('main', 'default_section');
            $action = $config->getOption('main', 'default_action');

            $request->setAction($action);
            $request->setSection($section);
            */
           // return $sectionMapper->getTemplateName($section, $action);
           return $sectionMapper->getTemplateName();
       /* }

        return $template;*/
    }
}

?>