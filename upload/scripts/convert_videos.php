<?php
define('_VALID', 1);
define('_ENTER', true);
define('_CLI', true);

// Argvs
$vdoname = $_SERVER['argv'][1];
$vid = (int) $_SERVER['argv'][2];
$vdo_path = $_SERVER['argv'][3];

// Required
$basedir = dirname(dirname(__FILE__));
require $basedir. '/include/config.php';
require $basedir. '/include/function_video.php';
require $basedir. '/include/function_conversions.php';

// Make sure these paths are availibale
$config['BASE_DIR'] 	= $basedir;
$config['TMP_DIR'] 		= $basedir.'/tmp';
$config['LOG_DIR'] 		= $basedir.'/tmp/logs';
$config['VDO_DIR'] 		= $basedir.'/media/videos/vid';
$config['FLVDO_DIR'] 	= $basedir.'/media/videos/flv';
$config['TMB_DIR'] 		= $basedir.'/media/videos/tmb';
$config['HD_DIR'] 		= $basedir.'/media/videos/hd';
$config['IPHONE_DIR'] 	= $basedir.'/media/videos/iphone';


$vi = array();
$vinfo = array();
$nl = "=========================================================\n";

echo "\n".$nl."Argv\n".$nl;
echo "Parameters:\n";
echo "vdoname: $vdoname\n";
echo "vid: $vid\n";
echo "vdo_path: $vdo_path\n\n";

// Error Checks
if (!preg_match("/^[0-9]{1,5}\.[a-z0-9]{2,4}$/i", $vdoname)){
	echo "vdoname: $vdoname is invalid. Err #1. Exiting ..."; exit();
}else{
	$vi = get_mediainfo_data($vdo_path);
}

// No Errors
if($vi['error'] == ''){
	$vinfo = videoInfo($vi);
}

$hd_overwrite = false;
// Conversion or Not !!Important Settings
// if ($vinfo['General_FileExtension'] == "flv" && $vinfo['General_Format'] == "Flash Video" && $vinfo['Video_Format'] != "AVC"){
if ($vinfo['General_FileExtension'] == "flv" && $vinfo['General_Format'] == "Flash Video"){
	$config['copyd'] = true;
}elseif (($vinfo['General_FileExtension'] == "flv" || $vinfo['General_FileExtension'] == "mp4") && $vinfo['General_Format'] == "MPEG-4" && $vinfo['Video_Format'] == "AVC"){
	$config['copyd'] = true;
	$hd_overwrite = true;
}elseif (($vinfo['General_FileExtension'] == "flv" || $vinfo['General_FileExtension'] == "mp4") && $vinfo['General_Format'] == "MPEG-4" && $vinfo['General_CodecID'] == "M4V" && $vinfo['Video_Format'] == "AVC"){
	$config['copyd'] = true;
	$hd_overwrite = true;
}elseif ($vinfo['General_Format'] == "MPEG-4" && stristr($vinfo['General_Format_Profile'], "3GPP") !== false && stristr($vinfo['General_CodecID'], "3gp") !== false){
	$config['copyd'] = false;
}else{
	$config['copyd'] = false;
}


$video_type = "normal";
// Assign $width Value
$vinfo['Original_Width'] = $vinfo['Video_Width'];
if ($vinfo['Video_DisplayAspectRatio'] > 0){
	if (round($vinfo['Video_Height'] * $vinfo['Video_DisplayAspectRatio']) > 1.01 * $vinfo['Original_Width'] || round($vinfo['Video_Height'] * $vinfo['Video_DisplayAspectRatio']) < 0.99 * $vinfo['Original_Width']){
		$vinfo['Video_Width'] = round($vinfo['Video_Height'] * $vinfo['Video_DisplayAspectRatio']);
	}
}

// Assign $aspect Value
$aspect = "4:3";
if (($vinfo['Video_DisplayAspectRatio'] >= 16/9 * 0.95) || ($vinfo['Video_DisplayAspectRatio'] == 0 && ($vinfo['Video_Width']/$vinfo['Video_Height'] >= 16/9 * 0.95)))
$aspect = "16:9";

// Assign $mc Value
if($vinfo['Video_CodecID'] == "WMV3")
$mc = " -mc 0";

// Assign $lavfopts Value
if (function_exists("verify_exec_path"))
verify_exec_path($config['mencoder'], "mencoder", 4);

$mencoder_version = '1.0rc1';
$mencoder_check = array();
exec($config['mencoder']." 2>&1",$mencoder_check);
if(isset($mencoder_check['0'])){
	if(!strstr($mencoder_check['0'], 'MEncoder 1.0rc1'))
	$mencoder_version = '1.0rc2';
}
if($mencoder_version == '1.0rc1')
$lavfopts = " -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames";

// Assign $framerate Value
if($video_type == "3gp" && $vinfo['Video_FrameRate'] == 0){
	$vinfo['Video_FrameRate'] = 15.0;
}elseif($vinfo['Video_FrameRate'] == 0 || $vinfo['Video_FrameRate'] == ''){
	$vinfo['Video_FrameRate'] = 29.970;
}

// Assign $ofps Value
$ofps = " -ofps ".$vinfo['Video_FrameRate'];
// Assign $keyint Value
$keyint = round($vinfo['Video_FrameRate'] * 8);
		
// Assign $demuxer Value
if ($vinfo['General_Format'] == "MPEG-4")
$demuxer = " -demuxer lavf";

// Display Details
echo "\n".$nl."Encoder Details\n".$nl;
echo "\$video_type = $video_type\n";
echo "\$aspect = $aspect\n";
echo "\$vinfo['Original_Width'] = ".$vinfo['Original_Width']."$original_width\n";
echo "\$vinfo['Video_Width'] = ".$vinfo['Video_Width']."\n";
echo "\$mc = $mc\n";
echo "\$lavfopts = $lavfopts\n";
echo "\$ofps = $ofps\n";
echo "\$demuxer = $demuxer\n";
echo "\$keyint = $keyint\n\n";

// Get Encoder
$encodings = getEncodings($video_type,$aspect,$vinfo,$hd_overwrite);
foreach($encodings as $encoding){
	convert($encoding,$vinfo,$vid,$vdo_path,$vdoname,$keyint,$lavfopts,$ofps,$mc,$demuxer,$aspect);	
}
postThumbs($vid,$vdo_path);
postConversion($vid,$vdo_path);

// Display :: Encoder Core End
echo "\n<-- End of Script -->\n\n";
exit();
?>
