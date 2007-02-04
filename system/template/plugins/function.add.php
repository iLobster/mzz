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
 * @version 0.2
 */
function smarty_function_add($params, $smarty)
{
    static $medias = array(array(), array('js' => array(), 'css' => array()));

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('Пустой атрибут', 'file');
    }

    if (!isset($medias[0][$params['file'] . (isset($params['tpl']) ? $params['tpl'] : '')])) {
        $medias[0][$params['file'] . (isset($params['tpl']) ? $params['tpl'] : '')] = true;
    } else {
        return;
    }

    // определяем тип ресурса
    // Первая часть - тип ресурс, вторая - файл ресурса
    $tmp = array_map('trim', explode(':', $params['file'], 2));

    if (sizeof($tmp) == 2 && strlen($tmp[0]) > 0) {
        // Ресурс указан
        $res = $tmp[0];
        $filename = $tmp[1];
    } else {
        // Ресурс не указан, пытаемся определить ресурс по расширению
        $params['file'] = str_replace(':', '', $params['file']);
        $res = substr(strrchr($params['file'], '.'), 1);
        $filename = $params['file'];
    }

    if (!isset($medias[1][$res])) {
        throw new mzzInvalidParameterException('Неверный тип ресурса', $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
        throw new mzzInvalidParameterException('Неверное имя файла', $filename);
    }

    // Если шаблон не указан, то используем шаблон соответствующий расширению
    $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';

    $vars = $smarty->get_template_vars('media');
    // если массив ещё пустой - создаём
    if ($vars === null) {
        $smarty->assign_by_ref('media', $medias[1]);
        $vars = $medias[1];
    }

    // ищем - подключали ли мы уже данный файл
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