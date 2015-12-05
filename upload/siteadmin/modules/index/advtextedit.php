<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$adv = array();
$AID = ( isset($_GET['AID']) ) ? intval($_GET['AID']) : NULL;
$sql = "SELECT * FROM adv_text WHERE adv_id = " .$AID. " LIMIT 1";
$rs  = $conn->execute($sql);
if ( !$conn->Affected_Rows() === 1 ) {
    $errors[] = 'Invalid text advertise id! Are you sure this advertise exists?!';
} else {
    $adv = $rs->getrows();
    $adv = $adv['0'];
}

if ( isset($_POST['adv_edit']) && !$errors ) {
    $title          = trim($_POST['adv_title']);
    $desc           = trim($_POST['adv_desc']);
    $url            = trim($_POST['adv_url']);
    $status         = intval(trim($_POST['adv_status']));
    
    if ( $title == '' ) {
        $errors[] = 'Advertising title field cannot be blank!';
    } elseif ( strlen($title) > 99 ) {
        $errors[] = 'Advertising title field can contain maximum 99 characters!';
    } else {
        $adv['title'] = $title;
    }
        
    if ( $desc != '' && strlen($desc) > 299 ) {
        $errors[] = 'Advertising description field cannot contain more then 299 characters!';
    } else {
        $adv['descr'] = $desc;
    }
    
    if ( $url == '' ) {
        $errors[] = 'Advertising url field cannot be blank!';
    } elseif ( !preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url) ) {
        $errors[] = 'Advertising url field is not a valid url!';
    } else {
        $adv['adv_url'] = $url;
    }
    
    $adv['status']   = ( $status === 0 ) ? 0 : 1;
    
    if ( !$errors ) {
        $sql = "UPDATE adv_text
                SET title = '" .mysql_real_escape_string($adv['title']). "',
                    descr = '" .mysql_real_escape_string($adv['descr']). "',
                    adv_url = '" .mysql_real_escape_string($adv['adv_url']). "',
                    status = '" .$adv['status']. "'
                WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $messages[] = 'Text Advertise was successfuly updated!';
    }
}

$smarty->assign('adv', $adv);
?>
