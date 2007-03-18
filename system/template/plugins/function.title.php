<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
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
 * smarty_function_title: ������� ��� Smarty, ������ ��������� ��������
 *
 * ������� �������������:<br />
 * <code>
 * {title append="�������" separator=" - "}
 * {title append="2007"}
 * {title append="������"}
 * {title separator=" | "} // ������� - 2007 | ������
 * </code>
 *
 * @param array $params ������� ��������� �������
 * @param object $smarty ������ ������
 * @return string|void ��������� ���� �� ������ �������� append
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_function_title($params, $smarty)
{
    static $titles = array();
    if (isset($params['append'])) {
        $titles[] = array($params['append'], isset($params['separator']) ? $params['separator'] : false);
    } else {
        $title = '';
        $separator = '';
        foreach ($titles as $t) {
            if (!is_null($t[0]) && $t[0] != '') {
                $separator = ($t[1] === false) ? (isset($params['separator']) ? $params['separator'] : '') : $t[1];
                $title .= $t[0] . $separator;
            }
        }
        //return substr($title, 0, -(strlen($separator)));
        return $title;
    }
}
?>