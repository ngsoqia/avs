<?php
// $param1 - language array index
function smarty_function_online_users($params, &$smarty)
{
	global $config;
	
	$online_users = 0;
	$sessions_dir   = $config['BASE_DIR']. '/tmp/sessions';
	if ( is_dir($sessions_dir) && is_writable($sessions_dir) ) {
		$online_users = count(scandir($sessions_dir))-3;
	}
	
	return $online_users;
}
?>
