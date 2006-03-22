<?php
//
// $Id: function.load.php 549 2006-03-22 15:03:46Z zerkms $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/template/plugins/function.load.php $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
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
 * @version 0.1
 */
function smarty_function_add($params, $smarty)
{
    $valid_resources = array('css', 'js');

    if (empty($params['file'])) {
        throw new mzzInvalidParameterException('Пустой аттрибут', 'file');
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

    if (!in_array($res, $valid_resources)) {
        throw new mzzInvalidParameterException('Неверный тип ресурса', $res);
    }

    if (!preg_match('/^[a-z0-9_\.?&=]+$/i', $filename)) {
        throw new mzzInvalidParameterException('Неверное имя файла', $filename);
    }

    // Если шаблон не указан, то используем шаблон соответствующий расширению
    $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';

    $vars = $smarty->get_template_vars($res);
    // если массив ещё пустой - создаём
    if ($vars === null) {
        $smarty->assign($res, array());
    }

    // ищем - подключали ли мы уже данный файл
    if (is_array($vars)) {
        foreach ($vars as $val) {
            if($val['file'] == $filename && $val['tpl'] == $tpl) {
                return null;
            }
        }
    }

    $smarty->append($res, array('file' => $filename, 'tpl' => $tpl));

}

?>