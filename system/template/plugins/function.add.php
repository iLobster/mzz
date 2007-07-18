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
 * @version 0.2.3
 */
function smarty_function_add($params, $smarty)
{
    static $medias = array(array(), array('js' => array(), 'css' => array()));

    $vars = $smarty->get_template_vars('media');

    // ������������� ������� media, ����������� ���� ��� ��� ������������ Smarty
    if (isset($params['init']) && $vars === null) {
        $smarty->assign_by_ref('media', $medias[1]);
        return;
    }

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('������ �������', 'file');
    }

    // ���������� ��� �������
    if (strpos($params['file'], ':')) {
        // ������ ������
        $tmp = explode(':', $params['file'], 2);
        $res = trim($tmp[0]);
        $filename = trim($tmp[1]);
    } else {
        // ������ �� ������, �������� ���������� ������ �� ����������
        $res = substr(strrchr($params['file'], '.'), 1);
        $filename = $params['file'];
    }

    // ���� ������ �� ������, �� ���������� ������ ��������������� ����������
    $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';

    if (isset($medias[0][$filename . $tpl])) {
        return;
    }
    $medias[0][$filename . $tpl] = true;

    if (!isset($medias[1][$res])) {
        throw new mzzInvalidParameterException('�������� ��� �������', $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
        throw new mzzInvalidParameterException('�������� ��� �����', $filename);
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