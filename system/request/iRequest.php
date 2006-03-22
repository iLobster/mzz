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
 * iRequest: ��������� ��� ������ � ���������
 *
 * @package system
 * @subpackage request
 * @version 0.1
 */

interface iRequest
{
    /**
     * ����� ��������� ���������� �� �������
     *
     * @param string $name ��� ����������
     * @param boolean $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public function get($name, $scope = null);

    /**
     * ���������� section
     *
     * @return string
     */
    public function getSection();

    /**
     * ���������� action
     *
     * @return string
     */
    public function getAction();

    /**
     * ��������� section
     *
     * @param string $value
     */
    public function setSection($value);

    /**
     * ��������� action
     *
     * @param string $value
     */
    public function setAction($value);

    /**
     * ��������� ������������� ���������
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value);

}

?>