<?php
//
// $Id: function.load.php 549 2006-03-22 15:03:46Z zerkms $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/template/plugins/function.load.php $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * smarty_function_add: ������� ��� ������, ��������� ��������� ����� (�������� JS, CSS)
 *
 * ������� �������������:<br />
 * <code>
 * {add file="styles.css"}
 * {add file="css:style_generator.php?print=1" tpl="css_print.tpl"}
 * </code>
 *
 * @param array $params ������� ��������� �������
 * @param object $smarty ������ ������
 * @return null|void null ���� ���� ��������
 * @package system
 * @version 0.1
 */
function smarty_function_add($params, $smarty)
{
    $valid_resources = array('css', 'js');

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('������ ��������', 'file');
    }

    // ���������� ��� �������
    // ������ ����� - ��� ������, ������ - ���� �������
    $tmp = array_map('trim', explode(':', $params['file'], 2));

    if (sizeof($tmp) == 2 && strlen($tmp[0]) > 0) {
        // ������ ������
        $res = $tmp[0];
        $filename = $tmp[1];
    } else {
        // ������ �� ������, �������� ���������� ������ �� ����������
        $params['file'] = str_replace(':', '', $params['file']);
        $res = substr(strrchr($params['file'], '.'), 1);
        $filename = $params['file'];
    }

    if (!in_array($res, $valid_resources)) {
        throw new mzzInvalidParameterException('�������� ��� �������', $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=]+$/i', $filename)) {
        throw new mzzInvalidParameterException('�������� ��� �����', $filename);
    }

    // ���� ������ �� ������, �� ���������� ������ ��������������� ����������
    $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';

    $vars = $smarty->get_template_vars($res);
    // ���� ������ ��� ������ - ������
    if ($vars === null) {
        $smarty->assign($res, array());
    }

    // ���� - ���������� �� �� ��� ������ ����
    if (is_array($vars)) {
        foreach ($vars as $val) {
            if($val['file'] == $filename && $val['tpl'] == $tpl) {
                return null;
            }
        }
    }

    $smarty->append($res, array('file' => $filename, 'tpl' => $tpl));

}

?>