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
 * @subpackage template
 * @version 0.2
 */
function smarty_function_add($params, $smarty)
{
    static $medias = array(array(), array('js' => array(), 'css' => array()));

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('������ �������', 'file');
    }

    if (!isset($medias[0][$params['file'] . (isset($params['tpl']) ? $params['tpl'] : '')])) {
        $medias[0][$params['file'] . (isset($params['tpl']) ? $params['tpl'] : '')] = true;
    } else {
        return;
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

    if (!isset($medias[1][$res])) {
        throw new mzzInvalidParameterException('�������� ��� �������', $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
        throw new mzzInvalidParameterException('�������� ��� �����', $filename);
    }

    // ���� ������ �� ������, �� ���������� ������ ��������������� ����������
    $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';

    $vars = $smarty->get_template_vars('media');
    // ���� ������ ��� ������ - ������
    if ($vars === null) {
        $smarty->assign_by_ref('media', $medias[1]);
        $vars = $medias[1];
    }

    // ���� - ���������� �� �� ��� ������ ����
    if (is_array($vars[$res])) {
        foreach ($vars[$res] as $val) {
            if ($val['file'] == $filename && $val['tpl'] == $tpl) {
                return null;
            }
        }
    }
    $medias[1][$res][] = array('file' => $filename, 'tpl' => $tpl);
}

?>