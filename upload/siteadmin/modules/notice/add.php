<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require_once ('editor_files/editor_functions.php');
require_once ('editor_files/config.php');
require_once ('editor_files/editor_class.php');

$editor = new wysiwygPro();
$editor->usexhtml(true);

$notice     = array('username' => '', 'title' => '', 'category' => '', 'content' => '');
if ( isset($_POST['submit_add_notice']) ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter     = new VFilter();
    $valid      = new VValidation();    
    $username   = $filter->get('username');
    $title      = $filter->get('title');
    $content    = trim($_POST['htmlCode']);
    $category   = $filter->get('category', 'INTEGER');
    
    if ( $username == '' ) {
        $errors[]   = 'Username field cannot be blank!';
    } elseif ( !$valid->usernameExists($username) ) {
        $errors[]   = 'Username does not exist!';
    } else {
        $notice['username'] = $username;
    }
    
    if ( $title == '' ) {
        $errors[]   = 'Notice title field cannot be blank!';
    } elseif ( strlen($title) > 299 ) {
        $errors[]   = 'Notice title field cannot contain more then 299 characters!';
    } else {
        $notice['title']    = $title;
    }
    
    if ( $category == '0' or $category == '' ) {
        $errors[]   = 'Please select a notice category!';
    } else {
        $notice['category'] = $category;
    }
    
    if ( $content == '' ) {
        $errors[]   = 'Notice content cannot be blank!';
    } else {
        $notice['content'] = $content;
    }
    
    if ( !$errors ) {
        $sql    = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $rs     = $conn->execute($sql);
        $uid    = $rs->fields['UID'];
        $sql    = "INSERT INTO notice (UID, category, title, content, addtime, adddate)
                   VALUES (" .intval($uid). ", " .intval($category). ", '" .mysql_real_escape_string($title). "',
                           '" .mysql_real_escape_string($content). "', " .time(). ", '" .date('Y-m-d'). "')";
        $conn->execute($sql);
        $_SESSION['message'] = 'Notice was successfully added!';
        VRedirect::go($config['BASE_URL']. '/siteadmin/notices.php?m=list');
    }
}

$sql        = "SELECT category_id, name FROM notice_categories
               WHERE status = '1' ORDER BY name DESC";
$rs         = $conn->execute($sql);
$categories = $rs->getrows();

$editor->set_code($notice['content']);

$smarty->assign('editor_wysiswyg', $editor->return_editor('100%', 350));
$smarty->assign('categories', $categories);
?>
