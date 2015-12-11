<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'include/function_user.php';
require 'classes/pagination.class.php';

if ( $config['video_view'] == 'registered' ) {
    require 'classes/auth.class.php';
    Auth::check();
}

$vid = get_request_arg('video');
if ( !$vid ) {
    VRedirect::go($config['BASE_URL']. '/error/video_missing');
}

$active     = ( $config['approve'] == '1' ) ? " AND v.active = '1'" : NULL;
$sql        = "SELECT v.VID, v.UID, v.title, v.channel, v.keyword, v.viewnumber, v.type,
                      v.addtime, v.rate, v.likes, v.dislikes, v.ratedby, v.flvdoname, v.space, v.embed_code, v.width_sd, v.height_sd, v.hd, v.iphone,
					  u.username, u.photo, u.gender, u.fname
               FROM video AS v, signup AS u WHERE v.VID = " .$vid. " AND v.UID = u.UID" .$active. " LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
//    VRedirect::go($config['BASE_URL']. '/error/video_missing');
}
$hd = $rs->fields['hd'];
$video_width		= $rs->fields['width_sd'];
$video_height		= $rs->fields['height_sd'];
$player_width = 640;
$embed_width = 530;
$embed_auto_height = round(530 * ($video_height/$video_width));

if ($hd==0) 
	{
		$autoheight	= round(640 * ($video_height/$video_width));
		$player_width = 640;
	}
if ($hd==1) 
	{
		$autoheight	= round(800 * ($video_height/$video_width));
		$player_width = 800;
	}

$video              = $rs->getrows();
$video              = $video['0'];
$guest_limit	    = false;

$video['keyword']   = explode(' ', $video['keyword']);
$uid                = ( isset($_SESSION['uid']) ) ? intval($_SESSION['uid']) : NULL;
$is_friend          = true;
if ( $video['type'] == 'private' && $uid != $video['UID'] ) {
    $sql = "SELECT FID FROM friends
            WHERE ((UID = " .intval($video['UID']). " AND FID = " .$uid. ")
            OR (UID = " .$uid. " AND FID = " .intval($video['UID']). "))
            AND status = 'Confirmed'
            LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() == 0 ) {
        $is_friend = false;
    }
}

if(!isset($_SESSION['uid'])){
	// 没有登录
	$t = time();
	$t_d = $t - ($t % (24*60*60));
	$sql = "select count(*) as cnt from playhistory where ip='" . getIP() . "' and vid='" . $vid . "' and playtime>" . $t_d ;
	$rs = $conn->execute($sql);
	if ( $rs->fields['cnt'] == 0 ) {
		$sql = "select count(*) as cnt from playhistory where ip='" . getIP() . "' and playtime>" . $t_d ;
		$rs = $conn->execute($sql);
		$playhisCount = $rs->fields['cnt'];
		if($playhisCount >= 10){	
			// 游客可看10个，已经不能再看了
			$smarty->assign('showName', $user['username']);
			$smarty->display('header.tpl');
			$smarty->display('video_limit.tpl');
			$smarty->display('footer.tpl');
			$smarty->gzip_encode();
			return;
			return;
		}else{
			$sql    = "INSERT INTO playhistory SET playtime = '" .time(). "' , vid = '" .$vid. "' , ip='". getIP() . "' ";
			$conn->execute($sql);
		}
	}else{
		// 看过该视频
	}
}else if(isset($_SESSION['uid']) && $uid != $video['UID']){
	// 登录了
	$sql    = "SELECT * FROM signup WHERE uid = '" . $uid . "' LIMIT 1";
	$rs = $conn->execute($sql);
	if ( $conn->Affected_Rows() != 0 ) {
		$user   = $rs->getrows();
		$user   = $user['0'];
		$t = time();
		$t_d = $t - ($t % (24*60*60));
		$conn->StartTrans();
		$sql = "select count(*) as cnt from playhistory where (ip='" . getIP() . "' or uid='" . $uid . "') and vid='" . $vid . "' and playtime>" . $t_d;
		$rs = $conn->execute($sql);
		if ( $rs->fields['cnt'] == 0 ) {
			if($user['vip_time']>time() || $user['vip_level']==7){
				// VIP
				$vipLevel = $user['vip_level'];
			}else{
				if($user['score']<5000){
					// 1级
					$vipLevel = 1;
				}else{
					// 2级
					$vipLevel = 2;
				}
			}
			$sql = "select count(*) as cnt from playhistory where (ip='" . getIP() . "' or uid='" . $uid . "') and playtime>" . $t_d ;
			$rs = $conn->execute($sql);
			$playhisCount = $rs->fields['cnt'];
			$count = getMaxCount4Vip($vipLevel);
			if($playhisCount>=$count){
				// 已经不能再看了
				$smarty->assign('showName', $user['username']);
				$smarty->display('header.tpl');
				$smarty->display('video_limit.tpl');
				$smarty->display('footer.tpl');
				$smarty->gzip_encode();
				return;
			}else {
				$sql    = "INSERT INTO playhistory SET playtime = '" .time(). "' , vid = '" .$vid. "' , ip='". getIP() . "' , uid='" . $uid . "'" ;
				$conn->execute($sql);
			}
		}else{
			// 看过该视频
		}
		$conn->CompleteTrans();
	}
}else{
	// 查看自己上传的视频
}

// 推广而来
$referer_id = $_REQUEST['u'];
if(isset($referer_id)){
	$_SESSION['referer_id'] = $referer_id;
	setcookie('referer_id', $referer_id, time()+60*60*24*100, '/');
	
	$sql = "select count(*) as cnt from refererhistory where ip='" . getIP() . "' and uid='" . $referer_id . "' and referertype=0 " ;
	$rs = $conn->execute($sql);
	$sql    = "INSERT INTO refererhistory SET ip = '" .getIP(). "' , uid = '" . $referer_id . "',  referertype=0, time='" . time() . "', vid='" . $vid . "'";
	$conn->execute($sql);
	if ( $rs->fields['cnt'] == 0 ) {
		$sql = "update signup SET score=score+" . $config['referer_video_score'] . " where uid='" . $referer_id . "'";
		$conn->execute($sql);
	}
}

$sql        = "UPDATE video SET viewnumber = viewnumber+1, viewtime='" .date('Y-m-d H:i:s'). "' WHERE VID = " .$vid. " LIMIT 1";
$conn->execute($sql);
$sql        = "UPDATE signup SET video_viewed = video_viewed+1 WHERE UID = " .intval($video['UID']). " LIMIT 1";
$conn->execute($sql);
if ( isset($_SESSION['uid']) ) {
    $sql    = "UPDATE signup SET watched_video = watched_video+1 WHERE UID = " .$uid. " LIMIT 1";
    $conn->execute($sql);
    $sql    = "SELECT UID FROM playlist WHERE UID = " .$uid. " AND VID = " .$vid. " LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() == 0 ) {
        $sql    = "INSERT INTO playlist SET UID = '" .$uid. "' , VID = '" .$vid. "'";
        $conn->execute($sql);
    }
}

$sql_add        = NULL;
if ( $video['keyword'] ) {
    $sql_add   .= " OR (";
    $sql_or     = NULL;    
    foreach ( $video['keyword'] as $keyword ) {
        $sql_add .= $sql_or. " keyword LIKE '%" .mysql_real_escape_string($keyword). "%'";
        $sql_or   = " OR ";
    }
    $sql_add   .= ")";
}


$sql_at		= NULL;
$sql_delim	= ' WHERE';
if ( $config['show_private_videos'] == '0' ) {
    $sql_at    .= $sql_delim. " type = 'public'";
    $sql_delim	= ' AND';
}

if ( $config['approve'] == '1' ) {
    $sql_at    .= $sql_delim. " active = '1'";
	$sql_delim  = ' AND';
}
$sql_at	       .= $sql_delim;

$sql            = "SELECT COUNT(VID) AS total_videos FROM video" .$sql_at. " channel = '" .$video['channel']. "' AND VID != " .$vid. "
                   AND ( title LIKE '%" .mysql_real_escape_string($video['title']). "%' " .$sql_add. ")";
$rsc            = $conn->execute($sql);
$total_related  = $rsc->fields['total_videos'];
if ( $total_related > 32 ) {
    $total_related = 32;
}
$pagination     = new Pagination(8, 'p_related_videos_' .$video['VID']. '_');
$limit          = $pagination->getLimit($total_related);
$sql            = "SELECT VID, title, duration, addtime, rate, likes, dislikes, viewnumber, type, thumb, thumbs, hd FROM video
                   WHERE active = '1' AND channel = '" .$video['channel']. "' AND VID != " .$vid. "
                   AND ( title LIKE '%" .mysql_real_escape_string($video['title']). "%' " .$sql_add. ")
                   ORDER BY addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$page_link      = $pagination->getPagination('video');

$sql            = "SELECT COUNT(CID) AS total_comments FROM video_comments WHERE VID = " .$vid. " AND status = '1'";
$rsc            = $conn->execute($sql);
$total_comments = $rsc->fields['total_comments'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total_comments);
$sql            = "SELECT c.CID, c.UID, c.comment, c.addtime, s.username, s.photo, s.gender
                   FROM video_comments AS c, signup AS s 
                   WHERE c.VID = " .$vid. " AND c.status = '1' AND c.UID = s.UID 
                   ORDER BY c.addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();
$page_link_c    = $pagination->getPagination('video', 'p_video_comments_' .$video['VID']. '_');
$page_link_cb   = $pagination->getPagination('video', 'pp_video_comments_' .$video['VID']. '_');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title         = $video['title'] . $seo['video_title'];
$self_description   = $video['title'] . $seo['video_desc'];
$self_keywords      = implode(', ', $video['keyword']) . $seo['video_keywords'];


	if (is_numeric($new_permisions['bandwidth']) && $new_permisions['bandwidth'] != '-1') {
		$user_limit_bandwidth = $new_permisions['bandwidth'];
		$remote_ip = ip2long($remote_ip);
		require $config['BASE_DIR']. '/classes/bandwidth.class.php';
		$guest_limit = VBandwidth::check($remote_ip, intval($video['space']));
	}


if ($new_permisions['watch_normal_videos'] == 0) {
	// nu are voie sa vada filme normale
	if ($type_of_user == 'guest') {
		$_SESSION['error'] = 'You need to register in order to watch videos';
		VRedirect::go($config['BASE_URL']. '/signup');
	} elseif ($type_of_user == 'free') {
		VRedirect::go($config['BASE_URL']. '/error/free_watch_permission');
	} elseif ($type_of_user == 'premium') {
		VRedirect::go($config['BASE_URL']. '/error/premium_watch_permission');
	}

}


$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'videos');
$smarty->assign('submenu', '');
$smarty->assign('view', true);
$smarty->assign('autoheight',$autoheight);
$smarty->assign('player_width',$player_width);
$smarty->assign('video_width',$video_width);
$smarty->assign('video_height',$video_height);
$smarty->assign('embed_width',$embed_width);
$smarty->assign('embed_auto_height',$embed_auto_height);
$smarty->assign('hd',$hd);
$smarty->assign('video', $video);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->assign('videos_total', $total_related);
$smarty->assign('videos', $videos);
$smarty->assign('page_link', $page_link);
$smarty->assign('comments_total', $total_comments);
$smarty->assign('comments', $comments);
$smarty->assign('page_link_comments', $page_link_c);
$smarty->assign('page_link_comments_bottom', $page_link_cb);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('is_friend', $is_friend);
$smarty->assign('guest_limit', $guest_limit);
$smarty->assign('new_permisions', $new_permisions);
$smarty->display('header.tpl');
$smarty->display('errors.tpl');
$smarty->display('messages.tpl');
$smarty->display('video.tpl');
$smarty->display('footer.tpl');
$smarty->gzip_encode();
?>
