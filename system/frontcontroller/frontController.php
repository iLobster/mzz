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
 * @version 0.2
 */

class frontController
{

    /**
     * ����������� ������
     *
     */
    public function __construct()
    {
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
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getSectionMapper()->getTemplateName();
    }
}

?>