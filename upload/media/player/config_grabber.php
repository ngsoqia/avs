<?php
define('_VALID', 1);
require '../../include/config.paths.php';
require '../../include/config.db.php';
require '../../include/config.local.php';
require '../../include/function_global.php';
require '../../include/function_language.php';
require '../../include/adodb/adodb.inc.php';
require '../../include/dbconn.php';
require '../../classes/curl.class.php';

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
    $sql    = "SELECT VID, title, channel, embed_code FROM video WHERE VID = '" .mysql_real_escape_string($_GET['vkey']). "' AND active = '1' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $video_id   = $rs->fields['VID'];
        $channel    = $rs->fields['channel'];
        $embed_code = $rs->fields['embed_code'];
        $title      = prepare_string($rs->fields['title']);
        $site = getVideoSitename($embed_code);
        $url  = getVideoUrl($embed_code);
        require  '../../classes/grabbers/' .$site. '.class.php';
        $class              = 'VGrab_' .$site;
        $graber             = new $class;
        $graber->getPage($url, $video_id);
        $flvurl = $graber->getVideoUrl();
	$SD_URL			= $flvurl;

    }
}

if ( !$video_id ) {
    die('Invalid video key!');
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

    function getVideoSitename($vurl)
    {
               $link = explode('vurl=',$vurl);
               $link = explode('"',$link[1]);
               $explode = explode(".", $link[0]);
               $tld = $explode[2];
               $tld = explode("/", $tld);
               $name = $explode[1];
               return $name;
    }

    function getVideoUrl($vurl)
    {
               $link = explode('vurl=',$vurl);
               $link = explode('"',$link[1]);
               return $link[0];
    }
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
    <image><?php echo $config['TMB_URL']. '/' .$video_id. '/default.jpg'; ?></image>
    <bufferTime><?php echo $player['buffertime']; ?></bufferTime>
    <src><?php echo $SD_URL; ?></src>
    <hd></hd>
	<ratio>fit</ratio> 

 

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
