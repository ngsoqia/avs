<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

// If Posted
if(isset($_POST['submit_media_mp4'])){
    $filter                 = new VFilter();
    
    //config settings
    $iphone_convert			= $filter->get('iphone_convert', 'INTEGER');
	
    //db settings
    $iphone_ovc_profile		= $filter->get('iphone_ovc_profile');
	$iphone_resize_base		= $filter->get('iphone_resize_base');
	$iphone_resize_width	= $filter->get('iphone_resize_width', 'INTEGER');
	$iphone_resize_height	= $filter->get('iphone_resize_height', 'INTEGER');
	$iphone_ref_bitrate		= $filter->get('iphone_ref_bitrate', 'INTEGER');	
	$iphone_ref_type		= $filter->get('iphone_ref_type');
	$iphone_blackbars		= $filter->get('iphone_blackbars', 'INTEGER');
	$iphone_encodepass		= $filter->get('iphone_encodepass', 'INTEGER');
	$iphone_audio_sampling	= $filter->get('iphone_audio_sampling', 'INTEGER');
	$iphone_audio_bitrate	= $filter->get('iphone_audio_bitrate', 'INTEGER');	

	// Set Defaults
	$iphone_ovc_profile 	= ($iphone_ovc_profile == '') ? 'standard' : $iphone_ovc_profile;
	$iphone_resize_base 	= ($iphone_resize_base == '') ? 'both' : $iphone_resize_base;
	$iphone_resize_width 	= ($iphone_resize_width == '') ? '480' : $iphone_resize_width;
	$iphone_resize_height 	= ($iphone_resize_height == '') ? '320' : $iphone_resize_height;
	$iphone_ref_bitrate 	= ($iphone_ref_bitrate == '') ? '1500' : $iphone_ref_bitrate;	
	$iphone_ref_type 		= ($iphone_ref_type == '') ? 'standard' : $iphone_ref_type;
	$iphone_encodepass 		= ($iphone_encodepass == '1') ? '1' : '2';
	$iphone_blackbars 		= ($iphone_blackbars == '0') ? '0' : '1';
	$iphone_audio_sampling 	= ($iphone_audio_sampling == '') ? '48000' : $iphone_audio_sampling;
	$iphone_audio_bitrate 	= ($iphone_audio_bitrate == '') ? '128' : $iphone_audio_bitrate;
	$iphone_template 		= ($iphone_template == '') ? 'mobile_default' : $iphone_template;
	$iphone_default_type 	= ($iphone_default_type == '') ? 'recent' : $default_type;
	
	// Checks
	if($iphone_ref_bitrate == '')
		$errors[] = 'Video Bit-rate for converted videos cannot be left blank!';
	elseif(!is_numeric($iphone_ref_bitrate))
		$errors[] = 'Video Bit-rate for converted videos must have a numeric value!';

	if($iphone_audio_bitrate == '')
		$errors[] = 'Audio Bit-rate for converted videos cannot be left blank!';
	elseif(!is_numeric($iphone_audio_bitrate))
		$errors[] = 'Audio Bit-rate for converted videos must have a numeric value!';
		
	if($iphone_audio_sampling == '')
		$errors[] = 'Sound sampling rate for converted videos cannot be left blank!';
	elseif(!is_numeric($iphone_audio_sampling))
		$errors[] = 'Sound sampling rate for converted videos must have a numeric value!';
		
	$config['iphone_convert']       = $iphone_convert;
	if ($config['flv_convert'] == 0 && $config['iphone_convert'] == 0) {
		$errors[] = 'You can\'t disable both FLV and Mobile Conversion!';
	}		
    // No Errors	
	if(!$errors){	
		// Update encoding profile in db
		$sql = "UPDATE encoding_avs SET"
			."  ovc_profile = '".$iphone_ovc_profile."'"
			.", resize_base = '".$iphone_resize_base."'"
			.", resize_width = '".$iphone_resize_width."'"
			.", resize_height = '".$iphone_resize_height."'"
			.", ref_bitrate = '".$iphone_ref_bitrate."'"
			.", ref_type = '".$iphone_ref_type."'"
			.", encodepass = '".$iphone_encodepass."'"
			.", blackbars = '".$iphone_blackbars."'"	
			.", audio_sampling = '".$iphone_audio_sampling."'"
			.", audio_bitrate = '".$iphone_audio_bitrate."'"
			." WHERE action = 'encode_ipod'"
		."";	
		$conn->execute($sql);
		
		// Update $config
		update_config($config);
        update_smarty();
		$messages[] = 'Conversion settings updated successfully!';
	}
}

// Get db Values
$sql = "SELECT ovc_profile, resize_base, resize_width, resize_height, ref_bitrate,"
	." ref_type, encodepass, blackbars, audio_sampling, audio_bitrate"
	." FROM encoding_avs"
	." WHERE video_type = 'normal'"
	." AND action = 'encode_ipod'"	
."";
$rs 			= $conn->execute($sql);
$ovc_profile 	= $rs->fields['ovc_profile'];
$resize_base 	= $rs->fields['resize_base'];
$resize_width 	= $rs->fields['resize_width'];
$resize_height 	= $rs->fields['resize_height'];
$ref_bitrate 	= $rs->fields['ref_bitrate'];
$ref_type 		= $rs->fields['ref_type'];
$encodepass 	= $rs->fields['encodepass'];
$blackbars 		= $rs->fields['blackbars'];
$audio_sampling = $rs->fields['audio_sampling'];
$audio_bitrate 	= $rs->fields['audio_bitrate'];

// iphone module frontend check
// Only Show Frontend setting if module is purchased.
$chk_file = $config['BASE_DIR'].'/modules/mobile/mobile_videos.php';
if(file_exists($chk_file) && $config['mobile_template'] != '') 
$smarty->assign('mobile_frontend', '1');

// smarty displays
$smarty->assign('sm_ovc_profile', $ovc_profile);
$smarty->assign('sm_resize_base', $resize_base);
$smarty->assign('sm_resize_width', $resize_width);
$smarty->assign('sm_resize_height', $resize_height);
$smarty->assign('sm_ref_bitrate', $ref_bitrate);
$smarty->assign('sm_ref_type', $ref_type);
$smarty->assign('sm_encodepass', $encodepass);
$smarty->assign('sm_blackbars', $blackbars);
$smarty->assign('sm_audio_sampling', $audio_sampling);
$smarty->assign('sm_audio_bitrate', $audio_bitrate);
?>
