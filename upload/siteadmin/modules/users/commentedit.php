<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$comment    = NULL;
$WID        = ( isset($_GET['WID']) && is_numeric($_GET['WID']) ) ? intval(trim($_GET['WID'])) : NULL;
if ( isset($_POST['edit_comment']) ) {
    $comment = trim($_POST['comment']);
    
    if ( $comment == '' ) {
        $errors[] = 'Please enter your comment!';
    }
    
    if ( !$errors ) {
        $sql    = "UPDATE wall SET message = '" .mysql_real_escape_string($comment). "'
                   WHERE wall_id = " .$WID. " LIMIT 1";
        $conn->execute($sql);
        $messages[]    = 'Comment successfully updated!';
    }
}

if ( $WID ) {
    $sql    = "SELECT message FROM wall WHERE wall_id = " .$WID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $comment = $rs->fields['message'];
    } else {
        $errors[] = 'Invalid comment id or not set!?';
    }
}

$smarty->assign('WID', $WID);
$smarty->assign('comment', $comment);
?>
