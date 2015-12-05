<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_global.php';
require '../include/function_admin.php';
require '../classes/auth.class.php';

Auth::checkAdmin();

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'all';
$module_keep        = NULL;
$module_template    = 'albums.tpl';
$modules_allowed    = array('all', 'view', 'edit', 'add', 'comments', 'commentedit', 'spam');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Blogs Module!';
}

switch ( $module ) {
    case 'view':
    case 'edit':
    case 'add':
    case 'spam':
    case 'comments':
    case 'commentedit':
        $module_template = 'blogs_' .$module. '.tpl';
        break;
    case 'all':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'blogs.tpl';
        break;
}
require 'modules/blogs/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module_keep);
$smarty->assign('active_menu', 'blogs');
$smarty->display('header.tpl');
$smarty->display('leftmenu/blogs.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
