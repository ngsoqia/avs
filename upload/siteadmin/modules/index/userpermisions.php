<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if (isset($_POST['submit_permisions_users'])) {
	foreach ($_POST as $k=>$v) {
		if ($k != '' and $k != 'submit_permisions_users')
			$config[$k] = $v;
	}
	update_config($config);
	update_smarty();
}
?>