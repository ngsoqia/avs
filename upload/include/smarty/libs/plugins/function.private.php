<?php
function smarty_function_private($params, &$smarty)
{
    global $config;
    
	$type		= $params['type'];
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') === FALSE) {
		return 'private-'.$type.'.png';
	} else {
		return 'private-'.$type.'.gif';
	}
}
?>
