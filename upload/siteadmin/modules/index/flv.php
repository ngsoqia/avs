<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_media_mp4']) ) {
    $filter                     = new VFilter(); 
	
    //config settings
    $flv_convert			= $filter->get('flv_convert', 'INTEGER');	
	
    //db settings
    $flv_ovc_profile			= $filter->get('flv_ovc_profile');
	$flv_resize_base			= $filter->get('flv_resize_base');
	$flv_resize_width			= $filter->get('flv_resize_width', 'INTEGER');
	$flv_resize_height		    = $filter->get('flv_resize_height', 'INTEGER');
	$flv_ref_bitrate			= $filter->get('flv_ref_bitrate', 'INTEGER');	
	$flv_ref_type				= $filter->get('flv_ref_type');
	$flv_blackbars				= $filter->get('flv_blackbars', 'INTEGER');
	$flv_encodepass				= $filter->get('flv_encodepass', 'INTEGER');
	$flv_audio_sampling			= $filter->get('flv_audio_sampling', 'INTEGER');
	$flv_audio_bitrate			= $filter->get('flv_audio_bitrate', 'INTEGER');
	
	//prep
	$flv_ovc_profile = ($flv_ovc_profile == '') ? 'standard' : $flv_ovc_profile;
	$flv_resize_base = ($flv_resize_base == '') ? 'both' : $flv_resize_base;
	$flv_resize_width = ($flv_resize_width == '') ? '480' : $flv_resize_width;
	$flv_resize_height = ($flv_resize_height == '') ? '320' : $flv_resize_height;
	$flv_ref_bitrate = ($flv_ref_bitrate == '') ? '1500' : $flv_ref_bitrate;	
	$flv_ref_type = ($flv_ref_type == '') ? 'standard' : $flv_ref_type;
	$flv_encodepass = ($flv_encodepass == '1') ? '1' : '2';
	$flv_blackbars = ($flv_blackbars == '0') ? '0' : '1';
	$flv_audio_sampling = ($flv_audio_sampling == '') ? '48000' : $flv_audio_sampling;
	$flv_audio_bitrate = ($flv_audio_bitrate == '') ? '128' : $flv_audio_bitrate;
	
	
	if ( $flv_ref_bitrate == '' )
		$errors[] = 'Video Bit-rate for converted videos cannot be left blank!';
	elseif( !is_numeric($flv_ref_bitrate) )
		$errors[] = 'Video Bit-rate for converted videos must have a numeric value!';

	if ( $flv_audio_bitrate == '' )
		$errors[] = 'Audio Bit-rate for converted videos cannot be left blank!';
	elseif( !is_numeric($flv_audio_bitrate) )
		$errors[] = 'Audio Bit-rate for converted videos must have a numeric value!';
		
	if ( $flv_audio_sampling == '' )
		$errors[] = 'Sound sampling rate for converted videos cannot be left blank!';
	elseif( !is_numeric($flv_audio_sampling) )
		$errors[] = 'Sound sampling rate for converted videos must have a numeric value!';
		
	$config['flv_convert'] = $flv_convert;
	if ($config['flv_convert'] == 0 && $config['iphone_convert'] == 0) {
		$errors[] = 'You can\'t disable both FLV and Mobile Conversion!';
	}
    	
	if (!$errors){
		// Update encoding profile
		$sql = "UPDATE encoding_avs SET"
			."  ovc_profile = '".$flv_ovc_profile."'"
			.", resize_base = '".$flv_resize_base."'"
			.", resize_width = '".$flv_resize_width."'"
			.", resize_height = '".$flv_resize_height."'"
			.", ref_bitrate = '".$flv_ref_bitrate."'"
			.", ref_type = '".$flv_ref_type."'"
			.", encodepass = '".$flv_encodepass."'"
			.", blackbars = '".$flv_blackbars."'"	
			.", audio_sampling = '".$flv_audio_sampling."'"
			.", audio_bitrate = '".$flv_audio_bitrate."'"
			." WHERE action = 'encode_h263'"
		."";	
		$conn->execute($sql);
			
		//$config['mobile_view_limit']			  = $mobile_view_limit;
		update_config($config);
        update_smarty();
		$messages[] = 'Conversion settings updated successfully!';
	}
}

// Get field Values
$sql = "SELECT ovc_profile, resize_base, resize_width, resize_height, ref_bitrate,"
	." ref_type, encodepass, blackbars, audio_sampling, audio_bitrate"
	." FROM encoding_avs"
	." WHERE video_type = 'normal'"
	." AND action = 'encode_h263'"	
."";
$rs = $conn->execute($sql);

$ovc_profile = $rs->fields['ovc_profile'];
$resize_base = $rs->fields['resize_base'];
$resize_width = $rs->fields['resize_width'];
$resize_height = $rs->fields['resize_height'];
$ref_bitrate = $rs->fields['ref_bitrate'];
$ref_type = $rs->fields['ref_type'];
$encodepass = $rs->fields['encodepass'];
$blackbars = $rs->fields['blackbars'];
$audio_sampling = $rs->fields['audio_sampling'];
$audio_bitrate = $rs->fields['audio_bitrate'];

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
