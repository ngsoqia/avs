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

$video_id   = ( isset($_GET['video_id']) && is_numeric($_GET['video_id']))  ? intval($_GET['video_id']) : NULL;
if ( !$video_id ) {
    die('Invalid video key!');
}

$mode   = ( isset($_GET['mode']) && ctype_alpha($_GET['mode']) ) ? $_GET['mode'] : 'related';
switch ( $mode ) {
    case 'commented':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate FROM video
                   WHERE type = 'public' AND active = '1' ORDER BY com_num DESC LIMIT 20";
        break;
    case 'featured':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate FROM video
                   WHERE type = 'public' AND featured = '1' AND active = '1' ORDER BY addtime DESC LIMIT 20";
        break;
    case 'rated':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate
                   FROM video WHERE type = 'public' AND active = '1' ORDER BY (ratedby*rate) DESC LIMIT 20";
        break;
    case 'viewed':
        $sql    = "SELECT VID, title, vkey, thumb, description, duration, rate
                   FROM video WHERE type = 'public' AND active = '1' ORDER BY viewnumber DESC LIMIT 20";
        break;
    default:
        $sql    = "SELECT title, keyword, description, channel FROM video WHERE VID = '" .mysql_real_escape_string($video_id). "' LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() != 1 ) {
            die('Invalid video key (video does not exist)!');
        }
        $video          = $rs->getrows();
        $keywords       = explode(' ', $video['0']['keyword']);
        $keywords_add   = NULL;
        $keywords_count = count($keywords);
        if ( $keywords_count > 1 ) {
            for ( $i=1; $i<$keywords_count; $i++ ) {
                $keywords_add .= " OR keyword LIKE '%" .mysql_real_escape_string($keywords[$i]). "%'";
            }
        }
        $sql_add        = " AND ( keyword LIKE '%" .mysql_real_escape_string($keywords['0']). "%' " .$keywords_add. ")";
		$sql			= "SELECT VID, title, vkey, thumb, description, duration, rate
		                   FROM video
						   WHERE type = 'public'
						   AND active = '1'
						   AND VID != '".mysql_real_escape_string($video_id)."'
						   AND channel = '".$video['0']['channel']."'".$sql_add."
						   ORDER BY VID DESC LIMIT 20";
}

$rs     = $conn->execute($sql);
$videos = $rs->getrows();

header('Content-Type: text/xml; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<xml>
    <videos>
    <?php foreach( $videos as $video ): ?>
        <video>
            <title><?php echo $video['title']; ?></title>
            <duration><?php echo duration($video['duration']); ?></duration>
            <url><?php echo $config['BASE_URL']. '/video/' .$video['VID']. '/' .prepare_string($video['title']); ?></url>
			<image><?php echo get_thumb_url($video['VID']). '/1.jpg'; ?></image>
            <desc><?php echo htmlspecialchars($video['description'], ENT_QUOTES, 'UTF-8'); ?></desc>
            <stars><?php echo $video['rate']; ?></stars>
        </video>
    <?php endforeach; ?>
    </videos>
</xml>
