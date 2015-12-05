<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$media_adv_dir = $config['BASE_DIR']. '/media/player/adv';
if (!file_exists($media_adv_dir) OR !is_dir($media_adv_dir) OR !is_writable($media_adv_dir)) {
	$errors[] = 'Media advertising folder does not exist or is not writable ('.$media_adv_dir.')!';
}

$adv = array('title' => '', 'desc' => '', 'channel' => 0, 'video' => 0, 'video_title' => '', 'url' => '', 'duration' => 5, 'status' => 0);
if ( isset($_GET['CHID']) ) {
    $CHID   = intval(trim($_GET['CHID']));
    if ( $CHID !== 0 ) {
        $adv['channel'] = intval(trim($_GET['CHID']));
    }    
}

if ( isset($_GET['VID']) ) {
    $VID    = intval(trim($_GET['VID']));
    if ( $VID !== 0 ) {
        $sql    = "SELECT title FROM video WHERE VID = " .$VID. " LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $adv['video']       = $VID;
            $adv['video_title'] = $rs->fields['title'];
        }
    }
}

if ( isset($_POST['adv_add']) ) {
    $title          = trim($_POST['adv_title']);
    $desc           = trim($_POST['adv_desc']);
    $url            = trim($_POST['adv_url']);
    $channel        = ( isset($_POST['adv_channel']) ) ? intval(trim($_POST['adv_channel'])) : 0;
    $video          = ( isset($_POST['adv_video']) ) ? intval(trim($_POST['adv_video'])) : 0;
    $video_title    = ( isset($_POST['adv_video_title']) ) ? intval(trim($_POST['adv_video_title'])) : 0;
    $duration       = intval(trim($_POST['adv_duration']));
    $status         = intval(trim($_POST['adv_status']));
    
    if ( $title == '' ) {
        $errors[] = 'Advertising title field cannot be blank!';
    } elseif ( strlen($title) > 99 ) {
        $errors[] = 'Advertising title field can contain maximum 99 characters!';
    } else {
        $adv['title'] = $title;
    }
        
    if ( $desc != '' && strlen($desc) > 199 ) {
        $errors[] = 'Advertising description field cannot contain more then 199 characters!';
    } else {
        $adv['desc'] = $desc;
    }
    
    if ( $url == '' ) {
        $errors[] = 'Advertising url field cannot be blank!';
    } elseif ( !preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url) ) {
        $errors[] = 'Advertising url field is not a valid url!';
    } else {
        $adv['url'] = $url;
    }
    
    $adv['duration'] = $duration;
    $adv['status']   = ( $status === 0 ) ? 0 : 1;
    
    if ( $_FILES['adv_media']['tmp_name'] == '' ) {
        $errors[] = 'Please select a advertising media file!';
    } elseif ( !is_uploaded_file($_FILES['adv_media']['tmp_name']) ) {
        $errors[] = 'Advertising media file is not a valid uploaded file!';
    } else {
        $filename = substr($_FILES['adv_media']['name'], strrpos($_FILES['adv_media']['name'], DIRECTORY_SEPARATOR)+1);
        $ext     = strtolower(substr($filename, strrpos($filename, '.')+1));
        if ( !in_array($ext, array('jpg', 'jpeg', 'swf', 'flv', 'mp4')) ) {
            $errors[] = 'Advertising media file is not a valid supported file format (allowed formats: jpg, swf, flv and mp4)!';
        } else {
            if ( $ext == 'jpeg' ) {
                $ext = 'jpg';
            }
        }
    }
    
    if ( !$errors ) {
        $sql    = "INSERT INTO adv_media (title, descr, adv_url, duration, media, addtime, status)
                   VALUES ('" .mysql_real_escape_string($adv['title']). "',
                           '" .mysql_real_escape_string($adv['desc']). "',
                           '" .mysql_real_escape_string($adv['url']). "',
                           " .$adv['duration']. ",
                           '" .mysql_real_escape_string($ext). "',
                           " .time(). ",
                           " .$adv['status']. ")";
        $conn->execute($sql);
        $adv_id = intval(mysql_insert_id());
        if ( !move_uploaded_file($_FILES['adv_media']['tmp_name'], $config['BASE_DIR']. '/media/player/adv/' .$adv_id. '.' .$ext) ) {
            $errors[] = 'Failed to move uploaded file!';            
        } else {
            $messages[] = 'Advertising media was successully added!';
        }
        
    }
}

$sql        = "SELECT CHID, name FROM channel ORDER BY name DESC";
$rs         = $conn->execute($sql);
$channels   = $rs->getrows();

$smarty->assign('adv', $adv);
$smarty->assign('channels', $channels);
?>
