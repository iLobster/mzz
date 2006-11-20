<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id$
*/

/**
 * iRequest: ��������� ��� ������ � �������� ���������
 *
 * @package system
 * @subpackage request
 * @version 0.7
 */

interface iRequest
{
    /**
     * ����� ��������� ���������� �� �������
     *
     * @param string $name ��� ����������
     * @param string  $type  ���, � ������� ����� ������������� ��������
     * @param boolean $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public function get($name, $type = 'mixed', $scope = null);

    /**
     * ����� ���������� ��������, ������� ��� ����������� ��� �������� ������.
     *
     */
    public function getMethod();

    /**
     * ���������� true ���� ������������ AJAX
     *
     * @return boolean
     */
    public function isAjax();

    /**
     * ���������� ������� ������
     *
     * @return string
     */
    public function getSection();

    /**
     * ������������� ������� ������
     *
     * @param string $section
     */
    public function setSection($section);

    /**
     * ���������� ������� ��������
     *
     * @return string
     */
    public function getAction();

    /**
     * ������������� ������� ��������
     *
     * @param string $action
     */
    public function setAction($action);

    /**
     * ��������� ������������� ���������
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value);

    /**
     * ��������� ������� ����������. ������������ ��������� ����� ����������
     *
     * @param array $params
     */
    public function setParams(Array $params);

    /**
     * ������� ������� ����������
     *
     * @return array
     */
    public function & getParams();

    /**
    * ��������� �������� ���� ��� ����
    *
    * @return string URL
    */
    public function getUrl();

    /**
    * ��������� �������� ���� c �����
    *
    * @return string URL
    */
    public function getRequestUrl();

    /**
    * ��������� �������� ����
    *
    * @return string PATH
    */
    public function getPath();
}

?>