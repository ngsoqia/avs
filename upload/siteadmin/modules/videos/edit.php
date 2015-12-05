<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$video  = array();
$VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
settype($VID, 'integer');
if ( !$VID ) 
    $errors[] = 'Invalid video ID. This video does not exist!';

if ( !$errors ) {
    if ( isset($_POST['edit_video']) ) {
        $title          = trim($_POST['title']);
        $keyword        = trim($_POST['keyword']);
        $channel        = trim($_POST['channel']);
        $type           = trim($_POST['type']);
        $featured       = trim($_POST['featured']);
        $be_comment     = trim($_POST['be_comment']);
        $be_rated       = trim($_POST['be_rated']);
        $embed          = trim($_POST['embed']);
        $thumb          = trim($_POST['thumb']);
        $rate           = trim($_POST['rate']);
        $ratedby        = trim($_POST['ratedby']);
        $viewnumber     = trim($_POST['viewnumber']);
        $com_num        = trim($_POST['com_num']);
        $fav_num        = trim($_POST['fav_num']);
        $active         = trim($_POST['active']);
		$server			= trim($_POST['server']);
        
        if ( strlen($title) < 3 )
            $errors[] = 'Video title field cannot be blank!';
        elseif ( strlen($keyword) < 3 )
            $errors[] = 'Video keyword(tags) field cannot be blank!';
        elseif ( $channel == '' )
            $errors[] = 'Select at least one channel and no more then 3!';
        
        if ( !$errors ) {
            settype($thumb, 'integer');
            settype($rate, 'float');
            settype($ratedby, 'integer');
            settype($viewnumber, 'integer');
            settype($com_num, 'integer');
            settype($fav_num, 'integer');
            settype($channel, 'integer');
        
            $sql = "UPDATE video SET title = '" .mysql_real_escape_string($title). "', keyword = '" .mysql_real_escape_string($keyword). "',
                                     channel = '" .$channel. "', type = '" .mysql_real_escape_string($type). "',
                                     featured = '" .mysql_real_escape_string($featured). "', be_comment = '" .mysql_real_escape_string($be_comment). "',
                                     be_rated = '" .mysql_real_escape_string($be_rated). "', embed = '" .mysql_real_escape_string($embed). "',
                                     thumb = '" .mysql_real_escape_string($thumb). "', rate = '" .mysql_real_escape_string($rate). "',
                                     ratedby = '" .mysql_real_escape_string($ratedby). "', viewnumber = '" .mysql_real_escape_string($viewnumber). "',
                                     com_num = '" .mysql_real_escape_string($com_num). "', fav_num = '" .mysql_real_escape_string($fav_num). "',
                                     active  = '" .mysql_real_escape_string($active). "', server = '".mysql_real_escape_string($server)."'
					WHERE VID = '" .mysql_real_escape_string($VID). "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'Video information updated successfuly!';
        }
    }

    $sql    = "SELECT * FROM video WHERE VID = '" .$VID. "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( mysql_affected_rows() == 1 ) {
        $video                  = $rs->getrows();
    }
    else
        $errors[]    = 'Invalid Video ID. This video does not exist!';
}

$sql        = "SELECT CHID, name FROM channel ORDER BY name ASC";
$rs         = $conn->execute($sql);
$channels   = $rs->getrows();

$smarty->assign('video', $video);
$smarty->assign('channels', $channels);
?>
