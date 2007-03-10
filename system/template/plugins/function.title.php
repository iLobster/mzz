<?php
function smarty_function_title($params, $smarty)
{
	$separator = isset($params['separator']) ? $params['separator'] : ' :: ';
	
	if(isset($params['set'])){
		$smarty -> assign('title', $params['set']);
	}
	
	if(isset($params['append'])){
		$title = $smarty->get_template_vars('title');
		$smarty -> assign('title_appended', $params['append']);
		$smarty -> assign('title', $title . $separator . $params['append']);
	}
}
?>