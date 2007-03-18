<?php
function smarty_function_title($params, $smarty)
{
    static $titles = array();

    if (isset($params['append'])) {
        $titles[] = array($params['append'], isset($params['separator']) ? $params['separator'] : false);
	} else {
	    $title = '';
        foreach ($titles as $t) {
            $separator = ( ($t[1] == false) ? $params['defaultSeparator'] : $t[1]);
            $title .= $t[0] . $separator;
        }

        if ($title) {
            $title = substr($title, 0, -1 * (strlen($separator)));
        }
        return $title;
	}
}
?>