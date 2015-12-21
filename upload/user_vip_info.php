<?php

require_once 'include/config.php';
require_once 'include/function_global.php';
require_once 'include/function_smarty.php';
require_once 'include/function_user.php';

if(isset($_SESSION['uid'])){
	// 登录了
	$sql    = "SELECT * FROM signup WHERE uid = '" . $_SESSION['uid'] . "' LIMIT 1";
	$rs = $conn->execute($sql);
	if ( $conn->Affected_Rows() != 0 ) {
		$user_vip_info   = $rs->getrows();
		$user_vip_info   = $user_vip_info['0'];
		
		$user_vip_info['vip_level'] = getUserVipLevel($user_vip_info);
		if($user_vip_info['vip_level']>=3 && $user_vip_info['vip_level']<=6){
			$user_vip_info['vip_time_left'] = ($user_vip_info['vip_time'] - time())/(24*60*60);
		}
		$user_vip_info['max_video_count'] = $config['level_video_'.$user_vip_info['vip_level']];
		$t = time();
		$t_d = $t - ($t % (24*60*60));
		$sql = "select count(*) as cnt from playhistory where (ip='" . getIP() . "' or uid='" . $uid . "') and playtime>" . $t_d;
		$rs = $conn->execute($sql);
		$user_vip_info['video_count_left'] = $user_vip_info['max_video_count'] - $rs->fields['cnt'];
				
	}
	$smarty->assign('user_vip_info',$user_vip_info);
}
?>
