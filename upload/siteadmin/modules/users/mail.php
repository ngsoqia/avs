<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/email.class.php';
require_once 'editor_files/editor_functions.php';
require_once 'editor_files/config.php';
require_once 'editor_files/editor_class.php';

$editor = new wysiwygPro();

$subject    = NULL;
$email      = ( isset($_GET['email']) ) ? trim($_GET['email']) : NULL;
$username   = ( isset($_GET['username']) ) ? trim($_GET['username']) : NULL;
$specific   = ( $email && $username ) ? true : false;
if ( isset($_POST['send_email']) ) {
    $email      = ( isset($_POST['email']) ) ? trim($_POST['email']) : NULL;
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['htmlCode']);
    $username   = trim($_POST['username']);
    
    if ( $specific ) {
        if ( $email == '' )
            $errors[] = 'Email field cannot be blank!';
        elseif ( !check_email($email) )
            $errors[] = 'Email is not a valid email address!';
    } else {
        if ( $username == '' )
            $errors[] = 'Username field cannot be empty!';
        else {
            $sql = "SELECT email FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
            $rs  = $conn->execute($sql);
            if ( $conn->Affected_Rows() )
                $email = $rs->fields['email'];
            else
                $errors[] = 'Username does not exist!';
        }        
    }
    
    if ( $subject == '' )
        $errors[] = 'Subject field cannot be empty!';
    elseif ( $message == '' )
        $errors[] = 'Email message cannot be empty!';
    
    if (!$errors) {
        $mail           = new VMail();
        $mail->set();
        $mail->Subject  = $subject;
        $mail->AltBody  = $message;
        $mail->Body     = nl2br($message);
        $mail->AddAddress($rs->fields['email']);
        if ( $mail->Send() ) {
            $messages[] = 'Email was successfuly sent to <b>' .$username. '</b>!';
        } else {
            $errors[]   = 'Failed to send email! Please check your <a href="index.php?m=mail">Mail Settings</a> and make sure the provided email is valid!';
        }
    }
}

$htmlCode   = ( isset($_POST['htmlCode']) ) ? trim($_POST['htmlCode']) : NULL;
$editor->set_code($htmlCode);

$smarty->assign('email', $email);
$smarty->assign('username', $username);
$smarty->assign('specific', $specific);
$smarty->assign('subject', $subject);
$smarty->assign('editor_wp', $editor->return_editor('100%', 350));
?>
