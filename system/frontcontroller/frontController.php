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
 * @version 0.4
 */
class frontController
{
     /**#@+
     * @var object
     */
    protected $request;
    protected $sectionMapper;
    /**#@-*/

    /**
     * ����������� ������
     *
     */
    public function __construct($request)
    {
        $toolkit = systemToolkit::getInstance();
        $this->request = $request;
        $this->sectionMapper = $toolkit->getSectionMapper();
    }

    /**
     * ��������� ����� ������� � ����-������������. ���������� ����� �������� ������
     * ���� ��������������� ���� �������� �� ����������
     *
     * @return string ��� ������� � ������������ � ���������� ������� � ������
     */
    public function getTemplate()
    {
        $section = $this->request->getSection();
        $action = $this->request->get('action', 'mixed', SC_PATH);

        $template_name = $this->sectionMapper->getTemplateName($section, $action);
        return $template_name;
    }

}

?>