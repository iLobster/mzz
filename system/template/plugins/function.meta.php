<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/template/plugins/function.keywords.php $
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
 * @version $Id: function.keywords.php 2253 2007-12-27 06:01:34Z zerkms $
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
 * @version 0.1
 */
function smarty_function_meta($params, $smarty)
{
    static $meta = array(
        'keywords' => array(),
        'description' => array()
    );

    if (isset($params['keywords']) || isset($params['description'])) {
        $type = isset($params['keywords']) ? 'keywords' : 'description';
        if (!empty($params['reset'])) {
            $meta[$type] = array();
        }
        $meta[$type][] = htmlspecialchars($params[$type]);
    } elseif (isset($params['show']) && in_array($params['show'], array_keys($meta))) {
        $default = (isset($params['default'])) ? htmlspecialchars($params['default']) : null;
        $result = join(', ', $meta[$params['show']]);
        if (empty($result)) {
            return $default;
        }

        return $result;
    }
}

?>