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
 * smarty_function_add: функция для смарти, загрузчик элементов сайта (например JS, CSS)
 *
 * Примеры использования:<br />
 * <code>
 * {add file="styles.css"}
 * {add file="css:style_generator.php?print=1" tpl="css_print.tpl"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return null|void null если файл дубликат
 * @package system
 * @subpackage template
 * @version 0.2.3
 */
function smarty_function_add($params, $smarty)
{
    static $medias = array('js' => array(), 'css' => array());

    $vars = $smarty->get_template_vars('media');

    // инициализация массива media, выполняется один раз при инстанциации Smarty
    if (isset($params['init']) && $vars === null) {
        $smarty->assign_by_ref('media', $medias);
        return;
    }

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('Пустой атрибут file');
    }

    // определяем тип ресурса
    if (strpos($params['file'], ':')) {
        // Ресурс указан
        $tmp = explode(':', $params['file'], 2);
        $res = trim($tmp[0]);
        $filename = trim($tmp[1]);
    } else {
        // Ресурс не указан, пытаемся определить ресурс по расширению
        $res = substr(strrchr($params['file'], '.'), 1);
        $filename = $params['file'];
    }

    // Если шаблон не указан, то используем шаблон соответствующий расширению
    $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';

    if (!isset($medias[$res])) {
        throw new mzzInvalidParameterException('Неверный тип ресурса: ' . $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
        throw new mzzInvalidParameterException('Неверное имя файла: ' . $filename);
    }

    // ищем - подключали ли мы уже данный файл
    if (isset($vars[$res][$filename]) && $vars[$res][$filename]['tpl'] == $tpl) {
        return null;
    }

    $join = true;
    if (isset($params['join']) && $params['join'] == false) {
        $join = false;
    }

    if (isset($params['require'])) {
        $require = explode(',', $params['require']);
        foreach($require as $requireFile) {
            smarty_function_add(array('file' => $requireFile, 'join' => $join), $smarty);
        }
    }
    $medias[$res][$filename] = array('tpl' => $tpl, 'join' => $join);
}

?>