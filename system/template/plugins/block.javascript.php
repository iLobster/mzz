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
 * smarty_block_javascript: �������� ������� ������ ��� ������� Javascript ���������������
 * � HTML-������ ��� ���������� ��� ��� ����������� ������� � XML.
 *
 * ������� �������������:<br />
 * <code>
 * {javascript}
 * alert('hello world!');
 * {/javascript}
 * </code>
 *
 * @param array $params ������� ��������� �������
 * @param string $content ���������� �������� �������
 * @param object $smarty ������ ������
 *
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_block_javascript($params, $content, $smarty)
{
    if ($content) {
        if ($smarty->isXml()) {
            $smarty->addJavascript($content);
        } else {
            echo "\r\n<script type=\"text/javascript\">\r\n<!--" . $content . "// -->\r\n</SCRIPT>\r\n";

        }
    }
}

?>