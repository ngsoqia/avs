<?php
define('_VALID', true);
define('_ADMIN', true);
include('../include/config.php');

$err = NULL;
$msg = NULL;
if ( isset($_POST['submit_login']) ) {
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);
        
    if ( $username == '' or $password == '' ) {
        $err = 'Please provide a username and password!';
    } else {
        if ( $username == $config['admin_name'] && $password == $config['admin_pass'] ) {
            $_SESSION['AUID']   = $config['admin_name'];
            $_SESSION['APASSWORD']  = $config['admin_pass'];
            VRedirect::go($config['BASE_URL']. '/siteadmin/index.php');
        } else {
            $err = 'Invalid username and/or password!';
        }
    }
}

if ( isset($_POST['submit_forgot']) ) {
    if ( !isset($_SESSION['email_forgot']) )
        $_SESSION['email_forgot'] = 1;
    
    if ( $_SESSION['email_forgot'] == 3 ) {
        $err = 'Please try again later!';
    }
    
    if ( $err == '' ) {
		require '../classes/email.class.php';
        $mail           = new VMail();
        $mail->set();
        $mail->Subject  = 'Your ' .$config['site_name']. ' administrator username and password!';
        $message        = 'Username: ' .$config['admin_name']. "\n";
        $message       .= 'Password: ' .$config['admin_pass']. "\n";
        $mail->AltBody  = $message;
        $mail->Body     = nl2br($message);
        $mail->AddAddress($config['admin_email']);
        $mail->Send();
        $msg = 'Email was successfuly sent!';
    }
    
    $_SESSION['email_forgot'] = $_SESSION['email_forgot']+1;
}

$smarty->assign('msg',$msg);
$smarty->assign('err',$err);
$smarty->display('header.tpl');
$smarty->display('login.tpl');
?>
