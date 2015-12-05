<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$mencoder	    = $config['mencoder'];
$mplayer	    = $config['mplayer'];
$metainject	    = $config['metainject'];
$metainject2	= $config['yamdi'];
$mediainfo		= $config['mediainfo'];
$mp4box			= $config['mp4box'];
$neroaacenc		= $config['neroaacenc'];
$php		    = $config['phppath'];
$ffmpeg         = $config['ffmpeg'];
$flvideo_dir	= $config['FLVDO_DIR'];
$video_dir	    = $config['VDO_DIR'];
$tmp_dir	    = $config['BASE_DIR']. '/tmp';
$thumbs_dir	    = $config['TMB_DIR'];
$albums_dir     = $config['BASE_DIR']. '/media/albums';
$photo_dir      = $config['BASE_DIR']. '/media/photos';
$photo_tmb_dir  = $config['BASE_DIR']. '/media/photos/tmb';
$game_dir       = $config['BASE_DIR']. '/media/games/swf';
$game_tmb_dir   = $config['BASE_DIR']. '/media/games/tmb';
$avatars_dir    = $config['BASE_DIR']. '/media/users';
$avatars_o_dir  = $config['BASE_DIR']. '/media/users/orig';
$video_cat_dir  = $config['BASE_DIR']. '/media/categories/video';
$photo_cat_dir  = $config['BASE_DIR']. '/media/categories/photo';
$game_cat_dir   = $config['BASE_DIR']. '/media/categories/game';
$restrictions	= array('safe_mode' => '', 'open_basedir' => '');
$upload		    = array('max_upload_size' => '', 'max_post_size' => '');
$binaries  	    = array('php' => '<b>missing</b>', 'mencoder' => '<b>missing</b>', 'mplayer' => '<b>missing</b>', 'ffmpeg' => '<b>missing</b>', 'metainject' => '<b>missing</b>', 'metainject2' => '<b>missing</b>', 'mediainfo' => '<b>missing</b>', 'MP4Box' => '<b>missing</b>', 'neroAacEnc' => '<b>missing</b>');
$paths		    = array('thumbs' => 'not writable', 'tmp' => 'not writable', 'flvideo' => 'not writable',
                        'video' => 'not writable', 'photo_dir' => 'not writable', 'albums_dir' => 'not writable',
						'photo_tmb_dir' => 'not writable', 'game_dir' => 'not writable', 'game_tmb_dir' => 'not writable',
						'avatars_dir' => 'not writable', 'avatars_o_dir' => 'not writable', 'video_cat' => 'not writable',
						'photo_cat' => 'not_writable', 'game_cat' => 'not_writable', 'sessions' => 'not writable',
						'thumb' => 'not_writable', 'logs' => 'not_writable', 'albums' => 'not writable',
						'avatars' => 'not_writable', 'download' => 'not writable');
$paths_perms	= array('thumbs' => '', 'tmp' => '', 'flvideo' => '', 'video' => '', 'photo_dir' => '',
                        'album_dir' => '', 'photo_tmb_dir' => '', 'game_dir' => '', 'game_tmb_dir' => '',
						'avatars_dir' => '', 'avatars_o_dir' => '',
                        'video_cat' => '', 'photo_cat' => '', 'game_cat' => '',
						'sessions' => '', 'thumb' => '', 'logs' => '', 'albums' => '',
						'avatars' => '', 'downloads' => '');
$formats 	    = array('h264' => 'missing', 'faac' => 'missing', 'lame' => 'missing', 'xvid' => 'missing', 'theora' => 'missing', 'jpeg' => 'missing');
$formats_paths 	= array('h264' => '', 'faac' => '', 'lame' => '', 'xvid' => '', 'theora' => '', 'jpeg' => '');

if ( file_exists($flvideo_dir) && is_dir($flvideo_dir) && is_writable($flvideo_dir) ) {
	$paths['flvideo'] 	= 'writable';
	$paths_perms['flvideo'] = substr(sprintf('%o', fileperms($flvideo_dir)), -4);
}

if ( file_exists($video_dir) && is_dir($video_dir) && is_writable($video_dir) ) {
	$paths['video'] 	= 'writable';
	$paths_perms['video'] = substr(sprintf('%o', fileperms($video_dir)), -4);
}

if ( file_exists($thumbs_dir) && is_dir($thumbs_dir) && is_writable($thumbs_dir) ) {
	$paths['thumbs'] 	= 'writable';
	$paths_perms['thumbs'] = substr(sprintf('%o', fileperms($thumbs_dir)), -4);
}

if ( file_exists($tmp_dir) && is_dir($tmp_dir) && is_writable($tmp_dir) ) {
	$paths['tmp'] 		= 'writable';
	$paths_perms['tmp'] 	= substr(sprintf('%o', fileperms($tmp_dir)), -4);
}

if ( file_exists($photo_dir) && is_dir($photo_dir) && is_writable($photo_dir) ) {
	$paths['photo_dir'] 	= 'writable';
	$paths_perms['photo_dir'] = substr(sprintf('%o', fileperms($photo_dir)), -4);
}

if ( file_exists($photo_tmb_dir) && is_dir($photo_tmb_dir) && is_writable($photo_tmb_dir) ) {
	$paths['photo_tmb_dir'] 	= 'writable';
	$paths_perms['photo_tmb_dir'] = substr(sprintf('%o', fileperms($photo_tmb_dir)), -4);
}

if ( file_exists($albums_dir) && is_dir($albums_dir) && is_writable($albums_dir) ) {
	$paths['albums_dir'] 	= 'writable';
	$paths_perms['albums_dir'] = substr(sprintf('%o', fileperms($albums_dir)), -4);
}

if ( file_exists($game_dir) && is_dir($game_dir) && is_writable($game_dir) ) {
	$paths['game_dir'] 	= 'writable';
	$paths_perms['game_dir'] = substr(sprintf('%o', fileperms($game_dir)), -4);
}

if ( file_exists($game_tmb_dir) && is_dir($game_tmb_dir) && is_writable($game_tmb_dir) ) {
	$paths['game_tmb_dir'] 	= 'writable';
	$paths_perms['game_tmb_dir'] = substr(sprintf('%o', fileperms($game_tmb_dir)), -4);
}

if ( file_exists($avatars_dir) && is_dir($avatars_dir) && is_writable($avatars_dir) ) {
	$paths['avatars_dir'] 	= 'writable';
	$paths_perms['avatars_dir'] = substr(sprintf('%o', fileperms($avatars_dir)), -4);
}

if ( file_exists($avatars_o_dir) && is_dir($avatars_o_dir) && is_writable($avatars_o_dir) ) {
	$paths['avatars_o_dir'] 	= 'writable';
	$paths_perms['avatars_o_dir'] = substr(sprintf('%o', fileperms($avatars_o_dir)), -4);
}

if (file_exists($video_cat_dir) && is_dir($video_cat_dir) && is_writable($video_cat_dir)) {
	$paths['video_cat']       = 'writable';
	$paths_persm['video_cat'] = substr(sprintf('%o', fileperms($video_cat_dir)), -4);
}

if (file_exists($photo_cat_dir) && is_dir($photo_cat_dir) && is_writable($photo_cat_dir)) {
	$paths['photo_cat']       = 'writable';
	$paths_persm['photo_cat'] = substr(sprintf('%o', fileperms($photo_cat_dir)), -4);
}

if (file_exists($game_cat_dir) && is_dir($game_cat_dir) && is_writable($game_cat_dir)) {
	$paths['game_cat']       = 'writable';
	$paths_persm['game_cat'] = substr(sprintf('%o', fileperms($game_cat_dir)), -4);
}

if ( file_exists($tmp_dir. '/sessions') && is_dir($tmp_dir. '/sessions') && is_writable($tmp_dir. '/sessions') ) {
	$paths['sessions'] 	= 'writable';
	$paths_perms['sessions'] = substr(sprintf('%o', fileperms($tmp_dir. '/sessions')), -4);
}

if ( file_exists($tmp_dir. '/thumbs') && is_dir($tmp_dir. '/thumbs') && is_writable($tmp_dir. '/thumbs') ) {
	$paths['thumb'] 	= 'writable';
	$paths_perms['thumb'] = substr(sprintf('%o', fileperms($tmp_dir. '/thumbs')), -4);
}

if ( file_exists($tmp_dir. '/logs') && is_dir($tmp_dir. '/logs') && is_writable($tmp_dir. '/logs') ) {
	$paths['logs'] 	= 'writable';
	$paths_perms['logs'] = substr(sprintf('%o', fileperms($tmp_dir. '/logs')), -4);
}

if (file_exists($tmp_dir. '/albums') && is_dir($tmp_dir. '/albums') && is_writable($tmp_dir. '/albums')) {
	$paths['albums'] = 'writable';
	$paths_perms['albums'] = substr(sprintf('%o', fileperms($tmp_dir. '/albums')), -4);
}

if (file_exists($tmp_dir. '/avatars') && is_dir($tmp_dir. '/avatars') && is_writable($tmp_dir. '/avatars')) {
	$paths['avatars'] = 'writable';
	$paths_perms['avatars'] = substr(sprintf('%o', fileperms($tmp_dir. '/avatars')), -4);
}

if (file_exists($tmp_dir. '/downloads') && is_dir($tmp_dir. '/downloads') && is_writable($tmp_dir. '/downloads')) {
	$paths['downloads'] = 'writable';
	$paths_perms['downloads'] = substr(sprintf('%o', fileperms($tmp_dir. '/downloads')), -4);
}

$upload['max_upload_size'] 	= ini_get('upload_max_filesize');
$upload['max_post_size']	= ini_get('post_max_size');

$restrictions['safe_mode']	= ini_get('safe_mode');
$restrictions['open_basedir']	= ini_get('open_basedir');

if ( file_exists($php) && is_file($php) && is_executable($php) )
	$binaries['php'] = 'found';
if ( file_exists($mencoder) && is_file($mencoder) && is_executable($mencoder) )
	$binaries['mencoder'] = 'found';
if ( file_exists($mplayer) && is_file($mplayer) && is_executable($mplayer) )
	$binaries['mplayer'] = 'found';
if ( file_exists($ffmpeg) && is_file($ffmpeg) && is_executable($ffmpeg) )
	$binaries['ffmpeg'] = 'found';
if ( file_exists($metainject) && is_file($metainject) && is_executable($metainject) )
	$binaries['metainject'] = 'found';

if ( file_exists($metainject2) && is_file($metainject2) && is_executable($metainject2) )
	$binaries['metainject2'] = 'found';
if ( file_exists($mediainfo) && is_file($mediainfo) && is_executable($mediainfo) )
	$binaries['mediainfo'] = 'found';
if ( file_exists($mp4box) && is_file($mp4box) && is_executable($mp4box) )
	$binaries['MP4Box'] = 'found';
if ( file_exists($neroaacenc) && is_file($neroaacenc) && is_executable($neroaacenc) )
	$binaries['neroAacEnc'] = 'found';



$formats_error = '';
if ( $binaries['mencoder'] == 'found' && $binaries['mplayer'] == 'found' ) {
	exec('/usr/bin/ldd ' .$mencoder, $output);
	if ( !$output ) {
		exec('/bin/ldd' .$mencoder, $output);
		if ( !$output ) {
			exec('/usr/local/bin/ldd' .$mencoder, $output);
			if ( !$output ) {
				exec('/sbin/ldd' .$mencoder, $output);
			}
		}
	}
	
	if ( $output ) {
		foreach ( $output as $key => $value ) {
			if ( strstr($value, 'libjpeg') ) {
				$array = explode(' => ', $value);
				$formats['jpeg'] 	= 'found';
				$formats_paths['jpeg']	= $array['1'];
			}
			if ( strstr($value, 'libmp3lame') ) {
				$array = explode(' => ', $value);
				$formats['lame'] 	= 'found';
				$formats_paths['lame']	= $array['1'];
			}
			if ( strstr($value, 'libxvidcore') ) {
				$array = explode(' => ', $value);
				$formats['xvid'] 	= 'found';
				$formats_paths['xvid']	= $array['1'];
			}
			if ( strstr($value, 'libfaac') ) {
				$array = explode(' => ', $value);
				$formats['faac'] 	= 'found';
				$formats_paths['faac']	= $array['1'];
			}
			if ( strstr($value, 'libx264') ) {
				$array = explode(' => ', $value);
				$formats['x264'] 	= 'found';
				$formats_paths['x264']	= $array['1'];
			}
			if ( strstr($value, 'libtheora') ) {
				$array = explode(' => ', $value);
				$formats['theora'] 	= 'found';
				$formats_paths['theora']= $array['1'];
			}
		}
	} else {
		$formats_error = 'Formats Error (could not find ldd binary)!';
	}
} else {
	$formats_error = 'Formats Error (mplayer or mencoder not installed)!';
}

$smarty->assign('flvideo_dir', $flvideo_dir);
$smarty->assign('video_dir', $video_dir);
$smarty->assign('thumbs_dir', $thumbs_dir);
$smarty->assign('photo_dir', $photo_dir);
$smarty->assign('photo_tmb_dir', $photo_tmb_dir);
$smarty->assign('albums_dir', $albums_dir);
$smarty->assign('game_dir', $game_dir);
$smarty->assign('game_tmb_dir', $game_tmb_dir);
$smarty->assign('avatars_dir', $avatars_dir);
$smarty->assign('avatars_o_dir', $avatars_o_dir);
$smarty->assign('video_cat_dir', $video_cat_dir);
$smarty->assign('photo_cat_dir', $photo_cat_dir);
$smarty->assign('game_cat_dir', $game_cat_dir);
$smarty->assign('tmp_dir', $tmp_dir);
$smarty->assign('upload', $upload);
$smarty->assign('binaries', $binaries);
$smarty->assign('paths', $paths);
$smarty->assign('paths_perms', $paths_perms);
$smarty->assign('formats', $formats);
$smarty->assign('formats_paths', $formats_paths);
$smarty->assign('formats_error', $formats_error);
$smarty->assign('restrictions', $restrictions);
?>
