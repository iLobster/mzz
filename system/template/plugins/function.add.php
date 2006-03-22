<?php

function smarty_function_add($params, $smarty)
{
    if (!empty($params['file'])) {
        // ���������� ��� �������
        $tmp = explode(':', $params['file'], 2);

        if (sizeof($tmp) == 2 && strlen($tmp[0]) > 0) {
            $res = $tmp[0];
            $filename = $tmp[1];
        } else {
            $res = substr(strrchr($params['file'], '.'), 1);
            $filename = $params['file'];
        }
        // ��������� ��� �����?

        if (isset($params['tpl'])) {
            $tpl = $params['tpl'];
        } else {
            $tpl = $res . '.tpl';
        }
        // ��������� ��� ����� �������

        $smarty->append($res, array('file' => $filename, 'tpl' => $tpl));
    }
    // ������ ������� �.�. ����� ������ ��� ��� �� ��� ��������
}

?>