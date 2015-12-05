<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$player = array('profile' => '', 'autorun' => 'true', 'buffertime' => 5, 'replay' => 1, 'related' => 1,
                'related_content' => 'related', 'share' => 1, 'mail' => 1, 'embed' => 1,
                'text_adv' => 1, 'text_adv_type' => 'global', 'text_adv_delay' => 5,
                'video_adv' => 1, 'video_adv_type' => 'global', 'video_adv_position' => 'b', 'skin' => 'default',
                'mail_color' => '0x999999', 'related_color' => '0x999999', 'replay_color' => '0x999999',
                'embed_color' => '0x999999', 'copy_color' => '0x999999', 'time_color' => '0x999999', 'share_color' => '0x999999',
		'adv_link_color' => '0x999999', 'adv_nav_color' => '0x999999',
		'adv_title_color' => '0x999999', 'adv_body_color' => '0x999999');
if ( isset($_POST['submit_add']) ) {
	$filter				= new VFilter();
    $profile            = $filter->process($_POST['profile']);
    $autorun            = $filter->process($_POST['autorun']);
    $buffertime         = intval($_POST['buffertime']);
    $buttons            = intval($_POST['buttons']);
    $replay             = intval($_POST['replay']);
    $related            = intval($_POST['related']);
    $related_content    = $filter->process($_POST['related_content']);
    $share              = intval($_POST['share']);
    $mail               = intval($_POST['mail']);
    $embed              = intval($_POST['embed']);
    $text_adv           = intval($_POST['text_adv']);
    $text_adv_type      = $filter->process($_POST['text_adv_type']);
    $text_adv_delay     = intval($_POST['text_adv_delay']);
    $video_adv          = intval($_POST['video_adv']);
    $video_adv_type     = $filter->process($_POST['video_adv_type']);
    $video_adv_position = $filter->process($_POST['video_adv_position']);
    $skin               = $filter->process($_POST['skin']);
    $mail_color         = $filter->process($_POST['mail_color']);
    $related_color      = $filter->process($_POST['related_color']);
    $replay_color       = $filter->process($_POST['replay_color']);
    $copy_color         = $filter->process($_POST['copy_color']);
    $embed_color        = $filter->process($_POST['embed_color']);
    $time_color         = $filter->process($_POST['time_color']);
    $share_color		= $filter->process($_POST['share_color']);
    $adv_nav_color      = $filter->process($_POST['adv_nav_color']);
    $adv_body_color     = $filter->process($_POST['adv_body_color']);
    $adv_title_color    = $filter->process($_POST['adv_title_color']);
    $adv_link_color     = $filter->process($_POST['adv_link_color']);
    
    // player rebranding
    $logo_url           = $filter->process($_POST['logo_url']);
    $logo_link          = $filter->process($_POST['logo_link']);
    $logo_position      = $filter->process($_POST['logo_position']);
    $logo_alpha         = intval($_POST['logo_alpha']);

    if ( $profile == '' ) {
        $errors[] = 'Please enter a name for your profile!';
    }
    
    if ( $buffertime == '0' ) {
        $errors[] = 'Please enter a value greater then 0 for the player buffertime!';
    }
    
    if ( $text_adv_delay == '0' ) {
        $errors[] = 'Please enter a value greater then 0 for the player text advertising delay!';
    }
    
    if ( !$errors ) {
        $autorun    = ( $autorun == 'true' ) ? 'true' : 'false';
        $buttons    = ( $buttons == '0' ) ? 0 : 1;
        $replay     = ( $replay == '0' ) ? 0 : 1;
        $related    = ( $related == '0' ) ? 0 : 1;
        $share      = ( $share == '0' ) ? 0 : 1;
        $mail       = ( $mail == '0' ) ? 0 : 1;
        $embed      = ( $embed == '0' ) ? 0 : 1;
        $text_adv   = ( $text_adv == '0' ) ? 0 : 1;
        $video_adv  = ( $video_adv == '0' ) ? 0 : 1;
        
        $sql        = "INSERT INTO player (profile, autorun, buffertime, buttons, skin, replay, share, mail, embed, related, related_content,
                                                    text_adv, text_adv_type, text_adv_delay, video_adv, video_adv_type, video_adv_position,
                                                    mail_color, related_color, replay_color, embed_color, copy_color, time_color, share_color,
                                                    adv_nav_color, adv_title_color, adv_body_color, adv_link_color,
													logo_url, logo_link, logo_position, logo_alpha)
                       VALUES ('" .mysql_real_escape_string($profile). "', '" .$autorun. "', '" .$buffertime. "', '" .$buttons. "', '" .mysql_real_escape_string($skin). "',
                               '" .$replay. "', '" .$share. "', '" .$mail. "', '" .$embed. "', '" .$related. "', '" .mysql_real_escape_string($related_content). "',
                               '" .$text_adv. "', '" .mysql_real_escape_string($text_adv_type). "', '" .$text_adv_delay. "',
                               '" .$video_adv. "', '" .mysql_real_escape_string($video_adv_type). "', '" .mysql_real_escape_string($video_adv_position). "',
                               '" .mysql_real_escape_string($mail_color). "', '" .mysql_real_escape_string($related_color). "',
                               '" .mysql_real_escape_string($replay_color). "', '" .mysql_real_escape_string($embed_color). "',
                               '" .mysql_real_escape_string($copy_color). "', '" .mysql_real_escape_string($time_color). "',
			      			   '" .mysql_real_escape_string($share_color). "',
                               '" .mysql_real_escape_string($adv_nav_color). "', '" .mysql_real_escape_string($adv_title_color). "',
                               '" .mysql_real_escape_string($adv_body_color). "', '" .mysql_real_escape_string($adv_link_color). "',
							   '" .mysql_real_escape_string($logo_url). "', '" .mysql_real_escape_string($logo_link). "',  
                               '" .mysql_real_escape_string($logo_position). "', '" .$logo_alpha. "')";
        $conn->execute($sql);
        $messages[] = 'New player profile successfully added!';
    }
}

$smarty->assign('skins', get_player_skins());
$smarty->assign('player', $player);
?>
