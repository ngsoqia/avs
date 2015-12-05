<?php
defined('_VALID') or die('Restricted Access!');

function plugin_index_login()
{
	global $config, $smarty;
	
	$smarty->display($config['BASE_DIR']. '/plugins/index_login/login.tpl');
}
?>
