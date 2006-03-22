<?php

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
        $added = false;

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
    }
    // кидать эксепшн т.к. левый ресурс или как то ещё ругаться
}

?>