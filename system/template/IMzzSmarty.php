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
 * @subpackage template
 * @version $Id$
*/

/**
 * IMzzSmarty: ����������� Smarty ��� ������ � ���������
 *
 * @version 0.5
 * @package system
 * @subpackage template
 */
interface IMzzSmarty
{
    /**
     * �����������
     *
     * @param object $smarty
     */
    function __construct(mzzSmarty $smarty);

    /**
     * ��������� ������ � ���������� ���������
     * ����������� ��� ���������� ��������� ��������.
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    function fetch($resource, $cache_id = null, $compile_id = null, $display = false);

    /**
     * �������� � ���������� ������������� ���� � ��������� ��������.
     * ���� ������ ������ ��������� � ����� ����� � ���������, �� ��������� ���,
     * ���� � ����� ���, �� � �������������� ���� ������������ ������ ����� ����� �� �����.
     *
     * ������:
     * <code>
     * news.view.tpl -> news/news.view.tpl
     * main.tpl -> main.tpl
     * </code>
     *
     * @param string $name
     * @param object $smarty
     * @return string
     */
    //function getResourceFileName($name);

    /**
     * ���������� ���������� � ����������� ��������
     *
     * @return string ���������� ����
     */
    public function getTemplateDir();

}

?>