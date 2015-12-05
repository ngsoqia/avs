<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/email.class.php';
require_once 'editor_files/editor_functions.php';
require_once 'editor_files/config.php';
require_once 'editor_files/editor_class.php';
$editor = new wysiwygPro();

if ( isset($_SESSION['email_errors']) ) {
    $errors[] = $_SESSION['email_errors'];
    unset($_SESSION['email_errors']);
}

$subject    = NULL;
$message    = NULL;
if ( isset($_POST['email_users']) ) {
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['htmlCode']);
    
    if ( $subject == '' )
        $errors[] = 'Subject field cannot be empty!';
    elseif ( $message == '' )
        $errors[] = 'Email message cannot be empty!';
    
    if ( !$errors ) {
        $email_errors   = array();
        $sql            = "SELECT email FROM signup WHERE account_status = 'Active'";
        $rs             = $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            while ( !$rs->EOF ) {
                $mail           = new VMail();
                $mail->set();
                $mail->Subject  = $subject;
                $mail->AltBody  = $message;
                $mail->Body     = nl2br($message);
                $mail->AddAddress($rs->fields['email']);
                if ( !$mail->Send() ) {
                    $email_errors[] = $rs->fields['email'];
                }
                $mail->ClearAddresses();
                $rs->movenext();
            }
        } else 
            $errors[] = 'No users! Is this your new site? :-)';
        
        if ( !$errors ) {
            if ( $email_errors )
                $_SESSION['email_errors'] = 'Could not send email to the following addresses: ' .implode(', ', $email_errors). '!';
            else
                $messages[] = 'Email was sent successfuly!';
        }
    }
}

$editor->set_code($message);

$smarty->assign('subject', $subject);
$smarty->assign('message', $message);
$smarty->assign('editor_wp', $editor->return_editor('100%', 350));
?>
