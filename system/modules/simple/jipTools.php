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
 * @package modules
 * @subpackage simple
 * @version $Id$
*/

/**
 * jipTools: ����������� ��� ������ � jip-������
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */
class jipTools
{
    /**
     * �������� ������ ��� ���������� JIP ����.
     * ���� $url == true, �� ����� �������� ���� JIP-���� ����� ��������� ���������� ���� ��������.
     * ��� ��������, �������� �� false � true, ����� ��������� ��������������� �������� �� ��������� URL.
     *
     * @param integer $howMany ������� ���������� ������� JIP ����. �� ��������� ����������� ������ ���� - �������
     * @param string|boolean $url true - �������� ���� ��������, ������ - �������� �� ������ URL
     * @param integer $timeout ����� �������� ����������� �� ��������� ��������� ���������� �����������
     * @return string HTML ���
     */
    static public function closeWindow($howMany = 1, $url = false, $timeout = 1500)
    {
        $html = '<script type="text/javascript"> window.setTimeout(function() {';
        if ($url) {
            $url = ($url === true) ? 'true' : '"' . $url . '"';
            $html .= 'jipWindow.refreshAfterClose(' . $url .'); ';
        }
        $html .= 'jipWindow.close(' . (int)$howMany . '); }, ' . (int)$timeout . '); </script>';
        $html .= '<p style="text-align: center; font-weight: bold; color: green; font-size: 120%;">���������� ���������...</p>';
        return $html;
    }

    static public function setRefreshAfterClose($url = true)
    {
        $html = '<script type="text/javascript"> jipWindow.refreshAfterClose(';
        $html .= ($url === true) ? 'true' : '"' . $url . '"';
        $html .= '); </script>';
        return $html;
    }

    /**
     * ���������� ���� �������� ��� ��������������� �� ������ URL
     *
     * @param string $url URL, �� ������� ����� ��������� ������������. �� ��������� ������������ ������� URL ��������
     * @return string HTML ���
     */
    static public function redirect($url = null)
    {
        $html = '<script type="text/javascript"> var toUrl = ';
        $html .= (!empty($url)) ? '"' . $url . '"' : "new String(window.location).replace(window.location.hash, '')";
        $html .= '; window.location = (toUrl.substring(toUrl.length - 1) != "#") ? toUrl : toUrl.substring(0, toUrl.length - 1); </script><p align="center"><span id="jipLoad">���������� ���� ��������...</span></p>';
        return $html;
    }
}

?>