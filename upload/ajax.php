<?php
define('_VALID', true);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

require 'include/config.paths.php';
require 'include/config.db.php';
require 'include/config.local.php';
require 'include/security.php';
require 'include/function_global.php';
require 'include/sessions.php';

disableRegisterGlobals();
require $config['BASE_DIR']. '/include/function_language.php';
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = $config['language'];
}
require $config['BASE_DIR']. '/language/'.$_SESSION['language'].'.lang.php';

$request            = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
if ( !$request ) {
    die('Invalid Request! Aborting!!!');
}

$module             = strtolower(substr($request, strrpos($request, '/')+1));
$modules_allowed    = array(
    'upload_progress'   => 1,
    'check_username'    => 1,
    'vote_video'        => 1,
    'vote_photo'        => 1,
    'vote_game'         => 1,
    'vote_user'         => 1,
    'album_cover'       => 1,
    'share_video'       => 1,
    'share_game'        => 1,
    'share_photo'       => 1,
    'photo_comment'     => 1,
    'video_comment'     => 1,
    'wall_comment'      => 1,
    'blog_comment'      => 1,
    'game_comment'      => 1,
    'notice_comment'        => 1,
    'video_comment_delete'  => 1,
    'game_comment_delete'   => 1,
    'photo_comment_delete'  => 1,
    'wall_comment_delete'   => 1,
    'notice_comment_delete' => 1,
    'blog_comment_delete'   => 1,
    'favorite_video'        => 1,
    'favorite_photo'        => 1,
    'favorite_game'         => 1,
    'flag_video'            => 1,
    'flag_photo'            => 1,
    'flag_game'             => 1,
    'photo_pagination'  => 1,
    'video_pagination'  => 1,
    'game_pagination'   => 1,
    'wall_pagination'   => 1,
    'blog_pagination'   => 1,
    'notice_pagination' => 1,
    'report_user'   => 1,
    'report_spam'   => 1,
    'static_read'   => 1,
    'static_write'  => 1,
    'static_preview'    => 1,
    'remove_photo_favorite' => 1,
    'remove_video_favorite' => 1,
    'remove_game_favorite' => 1,
    'remove_video_playlist' => 1,
    'related_videos'    => 1,
    'related_games' => 1,
    'search'    => 1,
    'accept_friend' => 1,
    'reject_friend' => 1,
    'invite_friend' => 1,
    'remove_friend' => 1,
    'blog_preview'  => 1,
    'subscribe' => 1,
    'unsubscribe'   => 1,
    'block_user'    => 1,
    'unblock_user'  => 1,
    'users' => 1,
    'insert_favorite_photos'    => 1,
    'insert_favorite_videos'    => 1,
    'insert_my_photos'  => 1,
    'insert_my_videos'  => 1,
    'insert_playlist_videos'    => 1,
    'category_videos'   => 1,
    'notice_preview'    => 1,
    'delete_photo'  => 1,
	'remove_subscriber' => 1,
	'remove_subscription' => 1,
	'language' => 1,
	'delete_video' => 1,
	'delete_game' => 1		
);
  
if ( isset($modules_allowed[$module]) && $modules_allowed[$module] === 1 ) {
    require 'include/ajax/' .$module. '.php';
} else {
    header('HTTP/1.0 404 Not Found');
}

die();
?>
