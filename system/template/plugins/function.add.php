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
 * @return string результат работы модуля
 * @package system
 * @version 0.1
 */
function smarty_function_add($params, $smarty)
{
    $valid_resources = array('css', 'js');

    if (!empty($params['file'])) {
        // определяем тип ресурса
        $tmp = array_map('trim', explode(':', $params['file'], 2));

        if (sizeof($tmp) == 2 && strlen($tmp[0]) > 0) {
            $res = $tmp[0];
            $filename = $tmp[1];
        } else {
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
        // проверить имя файла?

        $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';
        // проверить имя файла шаблона


        $vars = $smarty->get_template_vars($res);
        // если массив ещё пустой - создаём
        if ($vars === null) {
            $smarty->assign($res, array());
        }

        $added = false;

        // ищем - подключали лы мы уже данный файл
        if (is_array($vars)) {
            foreach ($vars as $val) {
                if ($val['file'] == $filename && $val['tpl'] == $tpl) {
                    $added = true;
                    break;
                }
            }
        }

        if (!$added) {
            $smarty->append($res, array('file' => $filename, 'tpl' => $tpl));
        }
    } else {
        throw new mzzInvalidParameterException('Пустой аттрибут', 'file');
    }
}

?>