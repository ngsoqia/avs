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
$modules_allowed    = array('all', 'public', 'private', 'view', 'edit', 'add', 'comments', 'commentedit',
                            'addphoto', 'viewphoto', 'editphoto', 'spam', 'flagged');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Albums Module!';
}

switch ( $module ) {
    case 'view':
    case 'edit':
    case 'add':
    case 'flagged':
    case 'spam':
    case 'viewphoto':
    case 'editphoto':
    case 'addphoto':
    case 'comments':
    case 'commentedit':
        $module_template = 'albums_' .$module. '.tpl';
        break;
    case 'all':
    case 'public':
    case 'private':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'albums.tpl';
        break;
}
require 'modules/albums/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module_keep);
$smarty->assign('active_menu', 'albums');
$smarty->display('header.tpl');
$smarty->display('leftmenu/albums.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
