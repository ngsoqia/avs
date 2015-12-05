<?php
define('_VALID', 1);
require '../../include/config.paths.php';
require '../../include/config.db.php';
require '../../include/config.local.php';
require '../../include/function_global.php';
require '../../include/function_language.php';
require '../../include/adodb/adodb.inc.php';
require '../../include/dbconn.php';
require_once ('../../include/function_thumbs.php');

$sql    = "SELECT * FROM player WHERE status = '1' LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $player = $rs->getrows();
    $player = $player['0'];
} else {
    die('Failed to load player profile!');
}

$video_id   = NULL;
if (isset($_GET['vkey']) && is_numeric($_GET['vkey'])) {
    $sql    = "SELECT VID, title, channel, server, flvdoname, ipod_filename, hd_filename, hd FROM video WHERE VID = '" .mysql_real_escape_string($_GET['vkey']). "' AND active = '1' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $video_id   = $rs->fields['VID'];
        $channel    = $rs->fields['channel'];
        $title      = prepare_string($rs->fields['title']);
		$server		= $rs->fields['server'];
		
		$sd_filename    = $rs->fields['flvdoname'];
		$hd_filename    = $rs->fields['hd_filename'];
		$hd    			= $rs->fields['hd'];
		$SD_URL			= $config['FLVDO_URL'].'/'.$sd_filename;
		$HD_URL			= $config['HD_URL'].'/'.$hd_filename;
		
		if ($sd_filename == '') {
			$sd_filename    = $rs->fields['ipod_filename'];
			$SD_URL			= $config['IPHONE_URL'].'/'.$sd_filename;
			$sd_mobile = true;
		} else {
			$sd_mobile = false;
		}
    }
}

if ( !$video_id ) {
    die('Invalid video key!');
}

if ($config['lighttpd'] == '1') {
	if ($sd_mobile) {
		$file_sd        = '/iphone/' .$video_id. '.mp4';
	} else {
		$file_sd        = '/flv/' .$video_id. '.flv';
	}
  	$file_hd        = '/hd/' .$video_id. '.mp4';
  	$timestamp      = time();
  	$timestamp_hex  = sprintf("%08x", $timestamp);
	$md5sum_sd      = md5($config['lighttpd_key'] . $file_sd . $timestamp_hex);
	$md5sum_hd      = md5($config['lighttpd_key'] . $file_hd . $timestamp_hex);
}

if ($config['multi_server'] == '1' && $server != '') {
    if ($config['lighttpd'] == '1') {
		$SD_URL    = $server.$config['lighttpd_prefix'].$md5sum_sd.'/'.$timestamp_hex.$file_sd;
		$HD_URL    = $server.$config['lighttpd_prefix'].$md5sum_hd.'/'.$timestamp_hex.$file_hd;
    } else {
        $rs = $conn->execute("SELECT video_url FROM servers WHERE url = '".$url."' LIMIT 1");
		if ($conn->Affected_rows()) {
			$video_url = $rs->fields['video_url'];
			$SD_URL = $video_url.'/'.$sd_filename;
			$HD_URL = $video_url.'/'.$hd_filename;
		} else {
			if ($sd_mobile) {
				$SD_URL = $server.'/media/videos/iphone/'.$sd_filename;
			} else {
				$SD_URL = $server.'/media/videos/flv/'.$sd_filename;
			}
			$HD_URL = $server.'/media/videos/hd/'.$hd_filename;
		}
    }
} else {
    if ($config['lighttpd'] == '1') {
		$SD_URL = $config['BASE_URL'].':81'.$config['lighttpd_prefix'].$md5sum_sd.'/'.$timestamp_hex.$file_sd;
  		$HD_URL = $config['BASE_URL'].':81'.$config['lighttpd_prefix'].$md5sum_hd.'/'.$timestamp_hex.$file_hd;
    }
}

$madv   = array('src' => '', 'mode' => 'none', 'duration' => '', 'link' => '');
$sql    = "SELECT adv_id, adv_url, media, duration FROM adv_media WHERE status = '1' ORDER BY rand() LIMIT 1";
$rs     = $conn->execute($sql);

if ( $conn->Affected_Rows() === 1 ) {
    $mid                = intval($rs->fields['adv_id']);
    $madv['src']        = $config['BASE_URL']. '/media/player/adv/' .$mid. '.' .$rs->fields['media'];
    $madv['mode']       = $player['video_adv_position'];
    $madv['duration']   = $rs->fields['duration'];
    $madv['link']       = $config['BASE_URL']. '/media/player/click.php?MID=' .$mid;
    $sql                = "UPDATE adv_media SET views = views+1 WHERE adv_id = " .$mid. " LIMIT 1";
    $conn->execute($sql);
}

// Is HD or Not
$HD_URL = ($hd == '1') ? $HD_URL : '';

header('Content-Type: text/xml; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<xml>
  <logo>
    <image><?php echo $config['BASE_URL']. '/media/player/logo/' .$player['logo_url']; ?></image>
    <position><?php echo $player['logo_position']; ?></position>
    <link><?php echo $player['logo_link']; ?></link>
    <alpha><?php echo $player['logo_alpha']; ?></alpha>
  </logo>
  <video>
    <autorun>false</autorun>
    <image><?php echo get_thumb_url($video_id). '/default.jpg'; ?></image>
    <bufferTime><?php echo $player['buffertime']; ?></bufferTime>
    <src><?php echo $SD_URL; ?></src>
    <hd><?php echo $HD_URL; ?></hd>
	<ratio>fit</ratio> 
    <?php if ($config['lighttpd'] == '1'): ;?> 
    <server>lighttpd</server> 
    <?php endif; ?> 
    <related><?php echo $config['BASE_URL']. '/media/player/related.php?mode=' .$player['related_content']. '&amp;video_id=' .$video_id; ?></related>
  </video>
  <mediaAdv>
    <src><?php echo $madv['src']; ?></src>
    <mode><?php echo $madv['mode']; ?></mode>
    <duration><?php echo $madv['duration']; ?></duration>
    <link><?php echo $madv['link']; ?></link>
  </mediaAdv>
  <textAdv<?php if ( $player['text_adv'] == '1' ) {; ?> enable="true"<?php } ?>>
    <src><?php echo $config['BASE_URL']. '/media/player/ads.php'; ?></src>
    <delay><?php echo $player['text_adv_delay']; ?></delay>
  </textAdv>
  <share><?php echo $config['BASE_URL']. '/video/' .$video_id. '/' .$title; ?></share>
  <embed><?php echo '<![CDATA[<embed width="452" height="361" quality="high" wmode="transparent" name="main" id="main" allowfullscreen="true" allowscriptaccess="always" src="' .$config['BASE_URL']. '/media/player/player.swf?f=' .$config['BASE_URL']. '/player/config_embed.php?vkey=' .$video_id. '" type="application/x-shockwave-flash" />]]>'; ?></embed>
  <skin><?php echo $config['BASE_URL']. '/media/player/skin.php?t=' .$player['skin']. '&amp;b=' .$player['buttons']. '&amp;r=' .$player['replay']. '&amp;e=' .$player['embed']. '&amp;s=' .$player['share']. '&amp;m=' .$player['mail']. '&amp;p=' .$player['related']. '&amp;mc=' .$player['mail_color']. '&amp;rc=' .$player['related_color']. '&amp;ec=' .$player['embed_color']. '&amp;rec=' .$player['replay_color']. '&amp;cc=' .$player['copy_color']. '&amp;tc=' .$player['time_color']. '&amp;sc=' .$player['share_color']. '&amp;anc=' .$player['adv_nav_color']. '&amp;atc=' .$player['adv_title_color']. '&amp;abc=' .$player['adv_body_color']. '&amp;alc=' .$player['adv_link_color']. '&amp;video=' .$video_id; ?></skin>
</xml>
