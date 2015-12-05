<?php
defined('_VALID') or die('Restricted Access!');

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require 'debug.php';
require 'config.paths.php';
require 'config.db.php';
require 'config.local.php';
require 'config.seo.php';
require 'config.language.php';

require $config['BASE_DIR']. '/classes/timer.class.php';
require $config['BASE_DIR']. '/classes/redirect.class.php';

if ($config['splash'] == '1' && !defined('_ENTER') && !defined('_ADMIN') && !defined('_MOBILE') && !defined('_CLI')) {
	if (!isset($_COOKIE['splash'])) {
		VRedirect::go($config['BASE_URL']. '/enter.php');
	}
}

require $config['BASE_DIR']. '/include/security.php';
require $config['BASE_DIR']. '/include/smarty/libs/Smarty.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

if ( !defined('_CONSOLE') ) {
    require $config['BASE_DIR']. '/include/sessions.php';
}

disableRegisterGlobals();

require $config['BASE_DIR']. '/include/function_language.php';
if (!isset($_SESSION['language'])) {
	$_SESSION['language'] = $config['language'];
}

if ($config['multi_language'] && isset($_POST['language'])) {
	$language = trim($_POST['language']);
	if (isset($languages[$language])) {
		$_SESSION['language'] = $language;
	}
}
require $config['BASE_DIR']. '/language/'.$_SESSION['language'].'.lang.php';

require $config['BASE_DIR']. '/classes/remember.class.php';
if ( !defined('_CONSOLE') && $config['gzip_encoding'] == 1 ) {
	ob_start();
	ob_implicit_flush(0);
}

$errors     = array();
$messages   = array();
if ( isset($_SESSION['message']) ) {
    $messages[] = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ( isset($_SESSION['error']) ) {
    $errors[] = $_SESSION['error'];
    unset($_SESSION['error']);
}

$remote_ip = ( isset($_SERVER['REMOTE_ADDR']) && long2ip(ip2long($_SERVER['REMOTE_ADDR'])) ) ? $_SERVER['REMOTE_ADDR'] : NULL;
if ( isset($_SESSION['uid']) ) {
    $sid    = intval($_SESSION['uid']);
    if ( $remote_ip ) {
        $sql    = "UPDATE signup SET user_ip = '" .mysql_real_escape_string($remote_ip). "' WHERE UID = " .$sid. " LIMIT 1";
        $conn->execute($sql);
    }
}

if ( $remote_ip ) {
	$sql = "SELECT ban_id FROM bans WHERE ban_ip = '" .mysql_real_escape_string($remote_ip). "' LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() > 0 ) {
    	    VRedirect::go($config['BASE_URL']. '?msg=You are banned from this site!');
	}
}

if ( $config['user_remember'] == '1' ) {
    Remember::check();
}

require 'smarty.php';

if ( $config['submenu_tag_scroller'] == '1' ) {
    $tags       = array();
    $sql        = "SELECT keyword FROM video WHERE active = '1' ORDER BY viewnumber LIMIT 10";
    $rs         = $conn->execute($sql);
    $rows       = $rs->getrows();
    foreach ( $rows as $row ) {
        $tag_arr = explode(' ', $row['keyword']);
        foreach ( $tag_arr as $tag ) {
            if ( strlen($tag) > 3 && !in_array($tag, $tags) ) {
                $tags[] = $tag;
            }
        }
    }
    
    $smarty->assign('scroller_content', $tags);
}

if ( isset($_SESSION['uid']) ) {
 $sid    = intval($_SESSION['uid']);
    $sql            = "UPDATE users_online SET online = '" .time(). "' WHERE UID = " .$sid. " LIMIT 1";
    $conn->execute($sql);
    $sql            = "SELECT COUNT(UID) AS total_requests FROM friends WHERE UID = " .$sid. " AND status = 'Pending'";
    $rs             = $conn->execute($sql);
    $requests_count = $rs->fields['total_requests'];
    $sql            = "SELECT COUNT(mail_id) AS total_mails FROM mail
                       WHERE receiver = '" .mysql_real_escape_string($_SESSION['username']). "' AND status = '1' AND readed = '0'";
    $rs             = $conn->execute($sql);
    $mails_count    = $rs->fields['total_mails'];
    $smarty->assign('requests_count', $requests_count);
    $smarty->assign('mails_count', $mails_count);
}

$user_permisions = array(
	'watch_normal_videos',
	'watch_hd_videos',
	'bandwidth',
	'sd_downloads',
	'hd_downloads',
	'mobile_downloads',
	'in_player_ads',
	'write_in_blog',
	'upload_video',
);
$new_permisions = array();
if (!isset($_SESSION['uid'])) {
	// user is guest
	$type_of_user = "guest";
	foreach ($user_permisions as $v) {
		$new_permisions[$v] = $config['visitors_'.$v];
	}	

} 
elseif (!isset($_SESSION['uid_premium']) && isset($_SESSION['uid'])) {
	// free user
	$type_of_user = "free";
	foreach ($user_permisions as $v) {
		$new_permisions[$v] = $config['free_'.$v];
	}	

} 
else {
	// premium user
	$type_of_user = "premium";
	foreach ($user_permisions as $v) {
		$new_permisions[$v] = $config['premium_'.$v];
	}	

}
?>
