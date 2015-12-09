<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';

// Added to enforce these paths
$basedir = dirname(dirname(dirname(__FILE__)));
$config['BASE_DIR'] 	= $basedir;
$config['LOG_DIR'] 		= $basedir.'/tmp/logs';

if ( isset($_POST['submit_card_pay']) ) {
    $filter     = new VFilter();
    $card_number = $filter->get('card_number');
    $card_pass   = $filter->get('card_pass');

    if ( $card_number == '' ) {
        $errors[]           = '请输入充值卡号！';
    } else {
        $card['number'] = $card_number;
    }

    if ( $card_pass == '' ) {
        $errors[]           = '请输入充值卡密码！';
    } else {
        $card['pass']  = $card_pass;
    }

    if ( !$errors ) {
        $sql = "select * from user_card where number='" . $card['number'] . "' and pass='" . $card['pass'] . "'";
        $rs = $conn->execute($sql);
		$cards = $rs->getrows();
		if(count($cards)==0){
			$errors[]   = '输入的充值卡账号或密码错误！';
		}
		if ( !$errors ) {
			$card   = $cards[0];
			if($card['used']==1){
				$errors[]   = '该充值卡已被使用！';
			}
			if(!$errors){
				$conn->StartTrans();
				if(intval($user['vip_level'])<3){
					// 原来是普通会员
					$vipTime = time();
					if($card['card_type']==1){
						$vipTime += 30*24*60*60;
					}else{
						$vipTime += 365*24*60*60;
					}
					$sql = "UPDATE signup SET vip_level='" . $card['vip_level'] . "', vip_time='" . $vipTime . "' WHERE UID = " .$uid;
					$conn->execute($sql);
				}else if(intval($card['vip_level']) == intval($user['vip_level'])){
					// 续时
					$vipTime = $user['vip_time'];
					if($card['card_type']==1){
						$vipTime += 30*24*60*60;
					}else{
						$vipTime += 365*24*60*60;
					}
					$sql = "UPDATE signup SET vip_level='" . $card['vip_level'] . "', vip_time='" . $vipTime . "' WHERE UID = " .$uid;
					$conn->execute($sql);
				}else if(intval($card['vip_level']) > intval($user['vip_level'])){
					// 升级VIP，原时间折合成高级VIP时间
					$radio = 0.5;
					$vipTimeDlta = ($user['vip_time'] - time()) * $radio;
					$vipTime = $user['vip_time'];
					if($card['card_type']==1){
						$vipTime = time() + 30*24*60*60 + $vipTimeDlta;
					}else{
						$vipTime = time() + 365*24*60*60 + $vipTimeDlta;
					}
					$sql = "UPDATE signup SET vip_level='" . $card['vip_level'] . "', vip_time='" . $vipTime . "' WHERE UID = " .$uid;
					$conn->execute($sql);
				}else if(intval($card['vip_level']) < intval($user['vip_level'])){
					// VIP不变，充值卡时间折合成当前用户等级时间
					$radio = 0.5;
					$vipTimeDlta = 0;
					if($card['card_type']==1){
						$vipTimeDlta = 30*24*60*60 * $radio;
					}else{
						$vipTimeDlta = 365*24*60*60 * $radio;
					}
					$vipTime = $user['vip_time'] + $vipTimeDlta;
					$sql = "UPDATE signup SET vip_time='" . $vipTime . "' WHERE UID = " .$uid;
					$conn->execute($sql);
				}
				$sql = "UPDATE user_card SET used='1', user_id='" . $uid. "', usetime='" . time() . "' where id=" . $card['id'];
				$conn->execute($sql);
				//$conn->RollbackTrans();
				
				$ret = $conn->CompleteTrans();
				if($ret){
					$messages[] = '充值成功！';
				}else{
					$errors[]   = '充值失败！';
				}
			}
            
        }
    }
}

$smarty->assign('card', $card);
?>
