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
    static $medias = array(array(), array('js' => array(), 'css' => array()));

    $vars = $smarty->get_template_vars('media');

    // инициализация массива media, выполняется один раз при инстанциации Smarty
    if (isset($params['init']) && $vars === null) {
        $smarty->assign_by_ref('media', $medias[1]);
        return;
    }

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('Пустой атрибут', 'file');
    }

    if ($params['file'] == 'jips') {
        $jips = array(
            'prototype.js' => 'js',
            'prototype_improvements.js' => 'js',
            'effects.js' => 'js',
            'dragdrop.js' => 'js',
            'jip.css' => 'css',
            'dtree.css' => 'css',
            'dtree.js' => 'js',
            'jip.js' => 'js',
            'calendar-blue.css' => 'css',
            'jscalendar/calendar.js' => 'js',
            'jscalendar/calendar-ru.js' => 'js',
            'jscalendar/calendar-ru.js' => 'js',
            'jscalendar/calendar-setup.js' => 'js',
            'tiny_mce/tiny_mce.js' => 'js'
        );

        foreach ($jips as $filename => $res) {
            if (!isset($medias[0][$filename . $res . '.tpl']) && isset($medias[1][$res])) {
                $medias[0][$filename . $res . '.tpl'] = true;

                if (is_array($vars[$res])) {
                    foreach ($vars[$res] as $val) {
                        if ($val['file'] == $filename && $val['tpl'] == $res . '.tpl') {
                            return null;
                        }
                    }
                }
                $medias[1][$res][] = array('file' => $filename, 'tpl' => $res . '.tpl');
            }
        }

        return null;
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

    if (isset($medias[0][$filename . $tpl])) {
        return;
    }
    $medias[0][$filename . $tpl] = true;

    if (!isset($medias[1][$res])) {
        throw new mzzInvalidParameterException('Неверный тип ресурса', $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
        throw new mzzInvalidParameterException('Неверное имя файла', $filename);
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