<?php
defined('_VALID') or die('Restricted Access!');

$card = array('number' => '', 'pass' => '', 'money' => '', 'vip_level' => '3',
              'used' => '', 'card_type' => '1', 'user_id' => '', 'addtime' => NULL, 
			  'card_count' => '1'
);

function getRndStr($length)
{
	$res = "";
	$pattern = "1234567890ABCDEFGHIJKLOMNOPQRSTUVWXYZ";
	for($i=0; $i<$length; $i++){
		$res .= $pattern{mt_rand(0,36)};
	}
	return $res;
}

if ( isset($_POST['add_card']) ) {
	require $config['BASE_DIR']. '/classes/filter.class.php';
	require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
	$vip_level			= $filter->get('vip_level');
	$card_type			= $filter->get('card_type');
    $money              = $filter->get('money');
    $card_count         = $filter->get('card_count');
	
	if ( $vip_level == '' ) {
		$errors[] = 'vip_level field cannot be blank!';
	} elseif ( !$valid->vipLevel($vip_level) ) {
		$errors[] = 'vip_level field is not a valid vip_level!';
	} else {
		$card['vip_level'] = $vip_level;
	}
	
	if ( $card_type == '' ) {
		$errors[] = 'card_type field cannot be blank!';
	} elseif ( !$valid->cardType($card_type) ) {
		$errors[] = 'card_type field is not a valid $card_type!';
	} else {
		$card['card_type'] = $card_type;
	}
	
	if ( $money == '' ) {
  		$errors[] = 'money field cannot be blank!';
    } elseif ( !$valid->money($money) ) {
        $errors[] = 'money is not a valid money!';
    } else {
		$card['money'] = $money;
	}

	if ( $card_count == '' ) {
  		$errors[] = 'card_count field cannot be blank!';
    } elseif ( !$valid->cardCount($card_count) ) {
        $errors[] = 'card_count is not a valid card_count!';
    } else {
		$card['card_count'] = $card_count;
	}

	if ( !$errors ) {
		for($i=0; $i<intval($card_count); $i++){
			$card['number']			= getRndStr(10);
			$card['pass']			= getRndStr(6);
			$card['addtime']		= time();
			$sql	= "INSERT INTO user_card SET money = '" . $card['money'] . "', " .
												"vip_level = '" . $card['vip_level'] . "', " . 
												"card_type = '" . $card['card_type'] . "', " . 
												"number = '" . $card['number'] . "', " . 
												"pass = '" . $card['pass'] . "', " . 
											    "addtime = '" .  $card['addtime'] . "'";
			$errors[] = $card['number']	. "   " . $card['pass'];
			$conn->execute($sql);
		}
	
		$messages[] = 'Card was successfully added!';
		
	}
}

$smarty->assign('card', $card);
?>
