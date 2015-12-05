<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$user  = array();
$UID   = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? intval(trim($_GET['UID'])) : NULL;
if ( !$UID )  {
    $errors[] = 'Invalid user ID!';
}

if ( !$errors ) {
    if ( isset($_GET['a']) && $_GET['a'] != '' ) {
        $action = trim($_GET['a']);
        if ( $action == 'activate' ) {
            $sql = "UPDATE signup SET account_status = 'Active' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            if ( mysql_affected_rows() == 1 )
                $messages[] = 'User activated successfuly!';
            else
                $errors[] = 'Failed to activate user!';
        }
        
        if ( $action == 'suspend' ) {
            $sql = "UPDATE signup SET account_status = 'Inactive' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            if ( mysql_affected_rows() == 1 )
                $messages[] = 'User suspended successfuly!';
            else
                $errors[] = 'Failed to suspend user!';
        }
    }

    $sql    = "SELECT * FROM signup WHERE UID = '" .$UID. "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( mysql_affected_rows() == 1 )
        $user = $rs->getrows();
    else
        $errors[] = 'This user does not exist! Invalid user ID?';
}

$smarty->assign('user', $user);
?>
