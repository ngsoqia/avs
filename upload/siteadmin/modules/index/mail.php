<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_mail']) ) {
    $filter         = new VFilter();
	$mailer			= $filter->get('mailer');
	$sendmail		= $filter->get('sendmail');
	$smtp			= $filter->get('smtp');
    $smtp_auth      = $filter->get('smtp_auth', 'INTEGER');
	$smtp_username	= $filter->get('smtp_username');
	$smtp_password	= $filter->get('smtp_password');
	$smtp_port		= $filter->get('smtp_port', 'INTEGER');
	$smtp_prefix	= $filter->get('smtp_prefix');
    
    if ( $mailer != 'mail' && $mailer != 'sendmail' && $mailer != 'smtp' ) {
        $errors[]   = 'Mailer can only be: PHP Mail Function, Sendmail or a SMTP server!';
    }
    
    if ( $mailer == 'sendmail' && $sendmail == '' ) {
        $errors[]   = 'Please enter sendmail path!';
    }
    
    if ( $mailer == 'smtp' ) {
        if ( $smtp == '' ) {
            $errors[]   = 'SMTP server cannot be null!';
        }
        
        if ( $smtp_auth == '1' ) {
            if ( $smtp_username == '' ) {
                $errrors[]  = 'SMTP Username field cannot be blank!';
            }
            
            if ( $smtp_password == '' ) {
                $errors[]   = 'SMTP Password field cannot be blank!';
            }
        }
    }
    
    if ( !$errors ) {
        $config['mailer']           = $mailer;
        $config['sendmail']         = $sendmail;
        $config['smtp']             = $smtp;
        $config['smtp_auth']        = $smtp_auth;
        $config['smtp_username']    = $smtp_username;
        $config['smtp_password']    = $smtp_password;
        $config['smtp_port']        = $smtp_port;
        $config['smtp_prefix']      = $smtp_prefix;
        update_config($config);
        update_smarty();
        $messages[] = 'Mail Settings Updated Successfully!';
    }
}
?>
