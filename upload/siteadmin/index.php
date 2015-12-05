<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_admin.php';
require '../classes/validation.class.php';
require '../classes/auth.class.php';
require '../classes/filter.class.php';

Auth::checkAdmin();

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'main';
$module_template    = 'index.tpl';
$modules_allowed    = array('main', 'check', 'mail', 'modules', 'static', 'media', 'iphone', 'flv', 'mp4', 'miscellaneous', 'permissions', 'sessions', 'bandwidth',
                            'bans', 'emails', 'emailadd', 'emailedit', 'advgroups', 'advs', 'advadd', 'advgroupedit', 'advedit',
							'advmedia', 'advtext', 'advmediaadd', 'advtextadd', 'advtextedit', 'advmediaedit', 'player', 'playeradd', 'playeredit', 'userpermisions');
if ( in_array($module, $modules_allowed) ) {
    $module_template = ( $module == 'main' ) ? 'index.tpl' : 'index_' .$module. '.tpl';
    require 'modules/index/' .$module. '.php';
} else {
    $err = 'Invalid Settings Module!';
}
$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('active_menu', 'index');
$smarty->display('header.tpl');
$smarty->display('leftmenu/index.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
