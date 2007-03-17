<?php
function smarty_function_title($params, $smarty)
{
    static $titles = array();

    if (isset($params['append'])) {
        $titles[] = array($params['append'], isset($params['separator']) ? $params['separator'] : ' :: ');
	} else {
	    $title = '';
        foreach ($titles as $t) {
            $title .= $t[0] . $t[1];
        }

        if ($title) {
            $title = substr($title, 0, -1 * (strlen($t[1])));
        }
        return $title;
	}
}
?>