<?php
defined('_VALID') or die('Restricted Access!');

require 'version.php';
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

// send hears - we dont cache anything in siteadmin
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

function channelExists( $chid, $game=false )
{
    global $conn;
    
    if ( $game === false ) {
        $sql = "SELECT CHID FROM channel WHERE CHID = '" .mysql_real_escape_string($chid). "' LIMIT 1";
    } else {
        $sql = "SELECT category_id FROM game_categories WHERE category_id = '" .mysql_real_escape_string($chid). "' LIMIT 1";
    }
    
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function categoryExists( $chid, $game=false )
{
    return channelExists($chid, $game);
}

function getVideoDuration( $vid )
{
    global $config;
  
    $flv = $config['FLVDO_DIR']. '/' .$vid. '.flv';
    if ( file_exists($flv) ) {
        exec($config['mplayer']. ' -vo null -ao null -frames 0 -identify "' .$flv. '"', $p);
        while ( list($k,$v) = each($p) ) {
            if ( $length = strstr($v, 'ID_LENGTH=') ) {
                break;
            }
        }
        
        $lx = explode('=', $length);
        
        return $lx['1'];
    }
    
    return false;
}

function regenVideoThumbs( $vid )
{
    global $config;
  
    $err        = NULL;
    $duration   = getVideoDuration($vid);
    if ( !$duration ) {
        $err = 'Failed to get video duration! Converted video not found!?';
    }
    
    $fc     = 0;
    $flv    = $config['FLVDO_DIR']. '/' .$vid. '.flv';
    if ( $err == '' ) {
        settype($duration, 'float');
        $timers = array(ceil($duration/2), ceil($duration/2), ceil($duration/3), ceil($duration/4));
        @mkdir($config['TMP_DIR']. '/thumbs/' .$vid);
        foreach ( $timers as $timer ) {
            if ( $config['thumbs_tool'] == 'ffmpeg' ) {
                $cmd = $config['ffmpeg']. ' -i ' .$flv. ' -f image2 -ss ' .$timer. ' -s ' .$config['img_max_width']. 'x' .$config['img_max_height']. ' -vframes 2 -y ' .$config['TMP_DIR']. '/thumbs/' .$vid. '/%08d.jpg';
            } else {
                $cmd = $config['mplayer']. ' ' .$flv. ' -ss ' .$timer. ' -nosound -vo jpeg:outdir=' .$config['TMP_DIR']. '/thumbs/' .$vid. ' -frames 2';
            }
            exec($cmd);
            $tmb    = ( $fc == 0 ) ? $vid : $fc. '_' .$vid;
            $fd     = get_thumb_dir($vid). '/' .$tmb. '.jpg';
            $ff     = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000002.jpg';
            if ( !file_exists($ff) )
                $ff = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000001.jpg';
            if ( !file_exists($ff) )
                $ff = $config['BASE_DIR']. '/images/default.gif';
            
            createThumb($ff, $fd, $config['img_max_width'], $config['img_max_height']);
            ++$fc;
        }
		delete_directory($config['TMP_DIR']. '/thumbs/' .$vid);
    }
    
    return $err;
}

function deleteVideo( $vid )
{
    global $config, $conn;
    
    $vid        = intval($vid);
    $sql        = "SELECT vdoname, channel FROM video WHERE VID = " .$vid. " LIMIT 1";
    $rs         = $conn->execute($sql);
    $vdoname    = $rs->fields['vdoname'];
    $chid    	= $rs->fields['channel'];
    
    if ( $config['multi_server'] == '1' ) {
		delete_video_ftp($vid);
    }
    
    // Define All Video Formats Possible
    $vdo 		= $config['VDO_DIR']	.'/'.$vdoname;
    $flv	 	= $config['FLVDO_DIR']	.'/'.$vid.'.flv';
    $iphone 	= $config['IPHONE_DIR']	.'/'.$vid.'.mp4';
    $mp4 		= $config['HD_DIR']	.'/'.$vid.'.mp4';
    
    if ( file_exists($flv) ) {
        @chmod($flv, 0777);
        @unlink($flv);
    }

    if ( file_exists($vdo) ) {
        @chmod($vdo, 0777);
        @unlink($vdo);
    }
    
    if ( file_exists($mp4) ) {
        @chmod($mp4, 0777);
        @unlink($mp4);
    }
    
    if ( file_exists($iphone) ) {
        @chmod($iphone, 0777);
        @unlink($iphone);
    }

	// AVS thumbs format
	delete_directory(get_thumb_dir($vid));
		
	// Update Channel Video Totals
    $sql = "UPDATE channel SET total_videos = total_videos - 1 WHERE CHID = " .$chid;
    $conn->execute($sql);
    
    
    $tables = array('video_comments', 'favourite', 'playlist', 'video');
    foreach ( $tables as $table ) {
        $sql = "DELETE FROM " .$table. " WHERE VID = " .$vid;
        $conn->execute($sql);
    }
}

function deleteAlbum( $aid )
{
    global $config, $conn;
    
    $sql    = "SELECT PID FROM photos WHERE AID = " .$aid;
    $rs     = $conn->execute($sql);
    $photos = $rs->getrows();
    $index  = 0;
    foreach ( $photos as $photo ) {
		//delete photos + thumbs
		$file = $config['BASE_DIR'].'/media/photos/'.$photo['PID'].'.jpg';
		if ( file_exists($file) ) {
			@chmod($file, 0777);
			@unlink($file);
		}
		$file = $config['BASE_DIR'].'/media/photos/tmb/'.$photo['PID'].'.jpg';
		if ( file_exists($file) ) {
			@chmod($file, 0777);
			@unlink($file);
		}
		
        $sql    = "DELETE FROM photos WHERE PID = " .$photo['PID']. " LIMIT 1";
        $conn->execute($sql);
        $sql    = "DELETE FROM photo_comments WHERE PID = " .$photo['PID'];
        $conn->execute($sql);
        $sql    = "DELETE FROM spam WHERE type = 'photo' AND parent_id = " .$photo['PID'];
        $conn->execute($sql);
        ++$index;
    }
    
    $sql    = "DELETE FROM albums WHERE AID = " .$aid;
    $conn->execute($sql);
	
	//delete album cover
	$file = $config['BASE_DIR'].'/media/albums/'.$aid.'.jpg';
	if ( file_exists($file) ) {
		@chmod($file, 0777);
		@unlink($file);
	}    
}

function albumExists( $aid )
{
    global $conn;
    
    $sql    = "SELECT AID FROM albums WHERE AID = " .intval($aid). " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();    
}

function photoExists( $pid )
{
    global $conn;
    
    $sql    = "SELECT PID FROM photos WHERE PID = " .intval($pid). " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function videoExists( $vid )
{
    global $conn;
    
    $sql = "SELECT VID FROM video WHERE VID = '" .mysql_real_escape_string($vid). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function blogExists( $bid )
{
    global $conn;
    
    $sql    = "SELECT BID FROM blog WHERE BID = " .intval($bid). " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->affected_rows();
}

function insert_user_byip($options)
{
    global $conn;
    
    $sql = "SELECT username FROM signup WHERE user_ip = '" .mysql_real_escape_string($options['ip']). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['username'];
                                
    return 'NO USER WITH THIS IP';
}

function insert_video_title($option)
{
    global $conn;
    
    $sql = "SELECT title, thumb FROM video WHERE VID = '" .mysql_real_escape_string($option['vid']). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->getrows();
    }
    
    return 'NO VIDEO ATTACHED!';
}

function insert_video_count( $options )
{
    global $conn, $config;
    
    $active     = ( $config['approve'] == '1' ) ? " AND active = '1'" : NULL;
    $type       = ( isset($options['type']) && ( $options['type'] == 'private' or $options['type'] == 'public' ) ) ? $options['type'] : NULL;
    $sql_add    = ( isset($type) ) ? " AND type = '" .mysql_real_escape_string($type). "'" : NULL;
    $uid        = intval($options['UID']);    
    $sql        = "SELECT COUNT(VID) AS total_videos FROM video WHERE UID = " .$uid . $sql_add . $active;
    $rs         = $conn->execute($sql);
    
    return $rs->fields['total_videos'];
}

function userExistsByUsername( $username )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function userExistsByID( $id )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE UID = '" .mysql_real_escape_string($id). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function makeTimeStamp($year='', $month='', $day='')
{
    if(empty($year)) {
        $year = strftime('%Y');
    }
    
    if(empty($month)) {
        $month = strftime('%m');
    }
    
    if(empty($day)) {
        $day = strftime('%d');
    }
                                       
    return mktime(0, 0, 0, $month, $day, $year);
}

function insert_get_video_title( $options )
{
    global $conn;
    
    $sql    = "SELECT title FROM video WHERE VID = '" .mysql_real_escape_string($options['VID']). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['title'];
    }
    
    return false;
}

function insert_get_game_title( $options )
{
    global $conn;
    
    $sql    = "SELECT title FROM game WHERE GID = '" .mysql_real_escape_string($options['GID']). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['title'];
    }
    
    return false;
}

function insert_video_thumbs( $options )
{
    global $config;
    
    $vid    = intval($options['VID']);
    $vkey   = $options['vkey'];
    $thumb  = $options['thumb'];
    $output = array();
    for ( $i=1; $i<=20; $i++ ) {
        $tmb            = get_thumb_dir($vid). '/' .$i. '.jpg';
        if ( file_exists($tmb) && is_file($tmb) ) {
            $class      = ( $thumb == $i ) ? 'tmb_active' : 'tmb';
            $output[]   = '<img src="' .get_thumb_url($vid). '/' .$i. '.jpg" width="72" id="change_tmb_' .$vkey. '_' .$i. '" class="' .$class. '">';
        }
    }
    
    return implode("\n", $output);
}

function insert_channel_count( $options )
{
    global $conn, $config;
    
    $active     = ( $config['approve'] == '1' ) ? " AND active = '1'" : NULL;
    $sql        = "SELECT COUNT(VID) AS total_videos FROM video WHERE channel = '" .intval($options['CHID']). "'" .$active;
    $rs         = $conn->execute($sql);
    
    return $rs->fields['total_videos'];
}

function insert_uid_to_name( $options )
{
    global $conn;
    
    $uid    = intval($options['uid']);
    $sql    = "SELECT username FROM signup WHERE UID = " .$uid. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['username'];
    }
    
    return 'unknown';
}

function update_config( $config )
{
    $buffer         = array();
    $buffer[]       = '<?php';
    $buffer[]       = 'defined(\'_VALID\') or die(\'Restricted Access!\');';
    foreach( $config as $key => $value ) {
        if ( !preg_match('/^[A-Z_]+/', $key) && !preg_match('/^db_(.*)/', $key) ) {
        	$buffer[]   = '$config[\'' .$key. '\'] = \'' .str_replace('\'', '&#039;', $value). '\';';
        }
    }
    $buffer[]       = '?>';
    
    $data           = implode("\n", $buffer);
    $path           = $config['BASE_DIR']. '/include/config.local.php';

    $fp = fopen($path, 'wb');
    if ($fp) {
        flock($fp, LOCK_EX);
        $len = strlen($data);
        fwrite($fp, $data, $len);
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}

function update_smarty()
{
    global $config, $smarty;
    
    foreach ( $config as $key =>  $value ) {
	$smarty->assign($key, $value);
    }
}

function deleteUser( $uid )
{
    global $config, $conn;

    $sql    = "SELECT UID FROM signup WHERE username = 'anonymous' LIMIT 1";
    $rs     = $conn->execute($sql);
    $auid   = intval($rs->fields['UID']);
	
	//REMOVE TOTAL COMMENTS
	//update total comments - blogs
	$sql = "SELECT BID FROM blog_comments WHERE UID = " .$uid;
	$rs = $conn->execute($sql);
	foreach ($rs as $value) {
		$sql        = "UPDATE blog SET total_comments = total_comments-1 WHERE BID = " .$value['BID'];
		$conn->execute($sql);
	}
	
	//update total comments - games
	$sql = "SELECT GID FROM game_comments WHERE UID = " .$uid;
	$rs = $conn->execute($sql);
	foreach ($rs as $value) {
		$sql        = "UPDATE game SET total_comments = total_comments-1 WHERE GID = " .$value['GID'];
		$conn->execute($sql);
	}

	//update total comments - photos / albums
	$sql = "SELECT PID FROM photo_comments WHERE UID = " .$uid;
	$rs = $conn->execute($sql);
	foreach ($rs as $value) {
		$sql        = "UPDATE photos SET total_comments = total_comments-1 WHERE PID = " .$value['PID'];
		$conn->execute($sql);
		$sql = "SELECT AID FROM photos WHERE PID = " .$value['PID']. " LIMIT 1";
		$rsa = $conn->execute($sql);
		$a_id   = intval($rsa->fields['AID']);
		$sql        = "UPDATE albums SET total_comments = total_comments-1 WHERE AID = " .$a_id;
		$conn->execute($sql);			
	}

	//update total comments - videos
	$sql = "SELECT VID FROM video_comments WHERE UID = " .$uid;
	$rs = $conn->execute($sql);
	foreach ($rs as $value) {
		$sql        = "UPDATE video SET total_comments = total_comments-1 WHERE VID = " .$value['VID'];
		$conn->execute($sql);
	}		
	//END REMOVE TOTAL COMMENTS	
	
    $sql    = "UPDATE video SET UID = " .$auid. " WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql    = "UPDATE albums SET UID = " .$auid. " WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql    = "UPDATE game SET UID = " .$auid. " WHERE UID = " .$uid;
    $conn->execute($sql);
	
    $tables = array('blog', 'signup', 'users_prefs', 'blog_comments', 'game_comments', 'notice_comments', 'photo_comments', 'video_comments', 
					'wall', 'confirm', 'favourite', 'friends', 'game_favorites', 'game_flags', 'game_rating_id', 'notice', 'photo_favorites', 
					'photo_flags', 'photo_rating_id', 'playlist', 'spam', 'users_blocks', 'users_flags', 'users_online', 'users_rating_id', 
					'video_comments', 'video_flags', 'video_subscribe', 'video_vote_users');
    foreach ( $tables as $table ) {
        $sql = "DELETE FROM " .$table. " WHERE UID = '" .mysql_real_escape_string($uid). "'";
        $conn->execute($sql);
    }
	
	//delete avatar
	$file = $config['BASE_DIR'].'/media/users/'.$uid.'.jpg';
	if ( file_exists($file) ) {
		@chmod($file, 0777);
		@unlink($file);
	}	

	$file = $config['BASE_DIR'].'/media/users/orig/'.$uid.'.jpg';
	if ( file_exists($file) ) {
		@chmod($file, 0777);
		@unlink($file);
	}	
	
}

function deleteBlog( $bid )
{
    global $conn;
    
    $bid    = intval($bid);
    $sql    = "SELECT UID FROM blog WHERE BID = " .$bid. " LIMIT 1";
    $rs     = $conn->execute($sql);
    $buid   = $rs->fields['UID'];
    $sel    = "UPDATE signup SET total_blogs = total_blogs-1 WHERE UID = " .$buid. " LIMIT 1";
    $conn->execute($sql);
    $sql    = "DELETE FROM blog_comments WHERE BID = " .$bid;
    $conn->execute($sql);
    $sql    = "DELETE FROM blog WHERE BID = " .$bid. " LIMIT 1";
    $conn->execute($sql);
}

function gameExists( $gid )
{
    global $conn;
    
    $gid    = intval($gid);
    $sql    = "SELECT GID FROM game WHERE GID = " .$gid. " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

function deleteGame( $gid )
{
    global $config, $conn;
    
    $gid    = intval($gid);
    $sql    = "SELECT UID, category FROM game WHERE GID = " .$gid. " LIMIT 1";
    $rs     = $conn->execute($sql);
    $guid   = intval($rs->fields['UID']);
	$gcid   = $rs->fields['category'];
    $sql    = "UPDATE signup SET total_games = total_games - 1 WHERE UID = " .$guid. " LIMIT 1";
    $conn->execute($sql);
    $sql = "UPDATE game_categories SET total_games = total_games - 1 WHERE category_id = " .$gcid;
    $conn->execute($sql);
    $tables = array('game_comments', 'game_favorites', 'game', 'game_rating_ip', 'game_rating_id',);
    foreach ( $tables as $table ) {
        $sql = "DELETE FROM " .$table. " WHERE GID = " .$gid;
        $conn->execute($sql);
    }

	$swf = $config['BASE_DIR']. '/media/games/swf/' .$gid. '.swf';
	if ( file_exists($swf) ) {
        @chmod($swf, 0777);
        @unlink($swf);
    }
	
	$thumb = $config['BASE_DIR']. '/media/games/tmb/' .$gid. '.jpg';
	if ( file_exists($thumb) ) {
        @chmod($thumb, 0777);
        @unlink($thumb);
    }
	
	$thumb = $config['BASE_DIR']. '/media/games/tmb/orig/' .$gid. '.jpg';
	if ( file_exists($thumb) ) {
        @chmod($thumb, 0777);
        @unlink($thumb);
    }	
}

function upload_video_ftp( $video_id )
{
    global $config;
    
    $conn	= ftp_connect($config['ftp_host']);
    debug_ftp('ftp_connect->' .$config['ftp_host']);
    $ftp_login	= ftp_login($conn, $config['ftp_username'], $config['ftp_password']);
    debug_ftp('ftp_login->' .$config['ftp_username']. ' - ' .$config['ftp_password']);
    if ( !$conn or !$ftp_login ) {
	die('Failed to connect to FTP server!');
    }
    
    $src = $config['BASE_DIR']. '/media/videos/flv/' .$video_id. '.flv';
    $dst = $config['ftp_root']. '/media/videos/flv/' .$video_id. '.flv';
    if ( file_exists($src) ) {
	ftp_pasv($conn, 1);
	debug_ftp('ftp_pasv->1');
	ftp_delete($conn, $dst);
	debug_ftp('ftp_delete->' .$dst);
	ftp_put($conn, $dst, $src, FTP_BINARY);
	debug_ftp('ftp_put->' .$src. ' - ' .$dst. ' (FTP_BINARY)');
	ftp_site($conn, sprintf('CHMOD %u %s', 777, $dst));
	debug_ftp('ftp_site->' .sprintf('CHMOD %u %s', 777, $dst));
    }
}

function delete_video_ftp( $video_id )
{
    global $config;
    
    $conn	= ftp_connect($config['ftp_host']);
    $ftp_login	= ftp_login($conn, $config['ftp_username'], $config['ftp_password']);
    if ( !$conn_id or !$ftp_login ) {
	die('Failed to connect to FTP server!');
    }
    
    ftp_pasv($conn, 1);
    ftp_delete($conn, $dst);
}

function debug_ftp( $msg )
{
    $DEBUG_FTP = false;
    if ( $DEBUG_FTP ) {
	echo $msg, "\n";
    }
}

function get_player_skins()
{               
    global $config;
            
    $skins      = array();
    $skins_dir  = $config['BASE_DIR']. '/media/player/skins';
	clearstatcache();
    if ( file_exists($skins_dir) && is_dir($skins_dir) ) {
        $files  = scandir($skins_dir);
        foreach ( $files as $file ) {
            if ( $file != 'index.php' && $file != '.' && $file != '..' && $file != 'index.html') {
                if ( is_dir($skins_dir. '/' .$file) ) {
                    $skins[] = $file;
                }
            }
        }
    }
        
    return $skins;
}

function send_game_approve_email($game_id)
{
	global $config, $conn;
	
	$sql = "SELECT g.GID, g.title, s.username, s.email FROM game AS g, signup AS s
	        WHERE g.GID = ".intval($game_id)." AND g.UID = s.UID
			LIMIT 1";
	$rs  = $conn->execute($sql);
	
	$gid      = $rs->fields['GID'];
	$title    = $rs->fields['title'];
	$username = $rs->fields['username'];
	$email    = $rs->fields['email'];
	
	$game_url  = $config['BASE_URL']. '/game/' .$gid. '/' .prepare_string($title);
	$game_link = '<a href="'.$game_url.'">'.$game_url.'</a>';
	$search     = array('{$site_title}', '{$site_name}', '{$username}', '{$game_link}', '{$baseurl}');
    $replace    = array($config['site_title'], $config['site_name'], $username, $game_link, $config['BASE_URL']);
    
	if (!class_exists('VMail')) {
		require $config['BASE_DIR']. '/classes/email.class.php';
	}
	
	$mail = new VMail();
	$mail->sendPredefined($email, 'game_approve', $search, $replace);
}

function send_video_approve_email($video_id)
{
    global $config, $conn;
    
    $sql        = "SELECT v.VID, v.title, s.username, s.email FROM video AS v, signup AS s
                  WHERE v.VID = " .intval($video_id). " AND v.UID = s.UID
                  LIMIT 1";
    $rs         = $conn->execute($sql);
	
	$vid		= intval($rs->fields['VID']);
	$title		= $rs->fields['title'];
	$username	= $rs->fields['username'];
	$email		= $rs->fields['email'];
	
	$video_url  = $config['BASE_URL']. '/video/'. $vid. '/' .prepare_string($title);
	$video_link = '<a href="'.$video_url.'">'.$video_url.'</a>';
    $search     = array('{$site_title}', '{$site_name}', '{$username}', '{$video_link}', '{$baseurl}');
    $replace    = array($config['site_title'], $config['site_name'], $username, $video_link, $config['BASE_URL']);

	if (!class_exists('VMail')) {
		require $config['BASE_DIR']. '/classes/email.class.php';
	}
	
	$mail = new VMail();
    $mail->sendPredefined($email, 'video_approve', $search, $replace);
}

function send_album_approve_email($album_id)
{
    global $config, $conn;
    
	$sql        = "SELECT a.AID, a.name, s.username, s.email FROM albums AS a, signup AS s
	               WHERE a.AID = ".intval($album_id)." AND a.UID = s.UID
				   LIMIT 1";
	$rs         = $conn->execute($sql);
	
	$aid		= intval($rs->fields['AID']);
	$name		= $rs->fields['name'];
	$username	= $rs->fields['username'];
	$email		= $rs->fields['email'];
	$album_url	= $config['BASE_URL']. '/album/' .$aid. '/' .prepare_string($name);
	$album_link	= '<a href="'.$album_url.'">'.$album_url.'</a>';
    $search     = array('{$site_title}', '{$site_name}', '{$username}', '{$album_link}', '{$baseurl}');
    $replace    = array($config['site_title'], $config['site_name'], $username, $album_link, $config['BASE_URL']);

	if (!class_exists('VMail')) {
		require $config['BASE_DIR']. '/classes/email.class.php';
	}
	
	$mail = new VMail();
    $mail->sendPredefined($email, 'video_approve', $search, $replace);
}

function insert_tmb_path($options)
{
	global $config;
	
	$vid   = $options['vid'];
	$index = intval( ($vid - 1) / $config['max_thumb_folders'] );
	$tmb_folder = 'tmb';
	if ($index !== 0) {
		$tmb_folder = 'tmb'.$index;
	}

	$output = $config['BASE_URL'].'/media/videos/'.$tmb_folder.'/'.$vid;

	return $output;
}

?>
