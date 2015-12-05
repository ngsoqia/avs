<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_admin.php';
require '../include/function_global.php';
require '../classes/auth.class.php';

Auth::checkAdmin();

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'all';
$module_template    = 'users.tpl';
$modules_allowed    = array('all', 'active', 'inactive', 'edit', 'view', 'view', 'mail',
                            'mailall', 'flagged', 'spam', 'commentedit', 'comments', 'add');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Users Module!';
}

$module_keep = NULL;
switch ( $module ) {
	case 'add':
    case 'edit':
    case 'view':
    case 'add':
    case 'mail':
    case 'mailall':
    case 'spam':
    case 'flagged':
    case 'commentedit':
    case 'comments':
        $module_template = 'users_' .$module. '.tpl';
        break;
    case 'all':
    case 'active':
    case 'inactive':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'users.tpl';
        break;
}
require 'modules/users/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module_keep);
$smarty->assign('active_menu', 'users');
$smarty->display('header.tpl');
$smarty->display('leftmenu/users.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
