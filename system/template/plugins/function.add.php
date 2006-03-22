<?php

function smarty_function_add($params, $smarty)
{
    $valid_resources = array('css', 'js');
    if (!empty($params['file'])) {
        // ���������� ��� �������
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
            throw new mzzInvalidParameterException('�������� ��� �������', $res);
        }

        if (!preg_match('/^[a-z0-9_\.?&=]+$/i', $filename)) {
            throw new mzzInvalidParameterException('�������� ��� �����', $filename);
        }
        // ��������� ��� �����?

        $tpl = (!empty($params['tpl'])) ? $params['tpl'] : $res . '.tpl';
        // ��������� ��� ����� �������

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
    // ������ ������� �.�. ����� ������ ��� ��� �� ��� ��������
}

?>