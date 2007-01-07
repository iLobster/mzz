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

fileLoader::load('acl');

/**
 * smarty_function_load: функция для смарти, загрузчик модулей
 *
 * Примеры использования:<br />
 * <code>
 * {load module="some_module_name" action="some_action"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 *
 * @package system
 * @subpackage template
 * @version 0.4.2
 */
function smarty_block_javascript($params, $content, $smarty)
{
    if ($content) {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        if ($request->isAjax()) {
            $smarty->addJavascript($content);
        } else {
            echo "\r\n<script type=\"text/javascript\">\r\n<!--" . $content . "// -->\r\n</SCRIPT>\r\n";

        }
    }
}

?>
