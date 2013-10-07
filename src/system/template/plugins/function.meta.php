<?php
/**
 * MZZ Content Management System (c)
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 */

/**
 * smarty_function_meta: функция для Smarty, для установки meta информации (ключевых слов и описания страницы)
 *
 * Примеры использования:<br />
 * <code>
 * {keywords keywords="новости, просмотр, в мире"}
 * {keywords description="просмотр новостей в мире"}
 * {keywords show="keywords"}
 * {keywords show="description" default="информационный сайт"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string
 * @package system
 * @subpackage template
 */
function smarty_function_meta(array $params, Smarty_Internal_Template $template)
{
    static $metas = array('keywords' => array(), 'description' => array());

    $template->smarty->assignByRef('__metas', $metas);

    if (isset($params['keywords']) || isset($params['description'])) {
        $type = isset($params['keywords']) ? 'keywords' : 'description';
        if (!empty($params['reset'])) {
            $metas[$type] = array();
        }
        $metas[$type][] = $params[$type];

    } elseif (isset($params['show']) && in_array($params['show'], array_keys($metas))) {
        $separator = $params['show'] == 'keywords' ? ', ' : ' ';
        $result = implode($separator, $metas[$params['show']]);
        if (empty($result)) {
            $result = (isset($params['default'])) ? $params['default'] : '';
        }

        if (isset($params['prepend'])) {
            $result = $params['prepend'] . ((!empty($result)) ? $separator . $result : '');
        }

        if (isset($params['append'])) {
            $result = ((!empty($result)) ? $result . $separator : '') . $params['append'];
        }

        return htmlspecialchars($result);
    }
}

?>