<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/validation.class.php';
require 'classes/filter.class.php';

$feedback       = array('department' => 'General', 'email' => '', 'name' => '', 'message' => '');
$departments    = array('General', 'Violations', 'Advertising');
if ( isset($_POST['submit_feedback']) ) {
    $filter     = new VFilter();
    $valid      = new VValidation();
    $department = $filter->get('department');
    $email      = $filter->get('email');
    $name       = $filter->get('name');
    $message    = $filter->get('message');
    $code       = $filter->get('verification');
    
    if ( !in_array($department, $departments) ) {
        $errors[]               = $lang['feedback.department_invalid'];
		$err['department']		= 1;
    } else {
        $feedback['department'] = $department;
    }
    
    if ( $email == '' ) {
        $errors[]               = $lang['global.email_empty'];
		$err['email']		    = 1;
    } elseif ( !$valid->email($email) ) {
        $errors[]               = $lang['global.email_invalid'];
		$err['email']		    = 1;
    } else {
        $feedback['email']      = $email;
    }
    
    if ( $name == '' ) {
        $errors[]               = $lang['feedback.name_empty'];
		$err['name']		    = 1;
    } else {
        $feedback['name']       = $name;
    }
    
    if ( $message == '' ) {
        $errors[]               = $lang['global.message_empty'];
		$err['message']		    = 1;
    } elseif ( mb_strlen($message) > 1000 ) {
        $errors[]               = translate('message_length', '1000');
		$err['email']		    = 1;
    } else {
        $feedback['message']    = $message;
    }
    
    if ( $_SESSION['captcha_code'] != strtoupper($code) ) {
        $errors[]               = $lang['global.verif_invalid'];
		$err['captcha']		    = 1;
    }
    
    if ( !$errors ) {
		require $config['BASE_DIR']. '/classes/email.class.php';
        $message            = "Department: " .$department. "\n\nMessage: " .$message;
        $mail               = new VMail();
        $mail->From         = $email;
        $mail->FromName     = $name;
        $mail->Sender       = $email;
        $mail->AddReplyTo($email, $name);
        $mail->Subject      = 'Feedback from ' .htmlspecialchars($name);
        $mail->AltBody      = $message;
        $mail->Body         = nl2br($message);
        $mail->AddAddress($config['admin_email']);
        $mail->Send();
        $messages[]         = $lang['feedback.sent'];
    }
}

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('feedback', $feedback);
$smarty->assign('self_title', $seo['feedback_title']);
$smarty->assign('self_description', $seo['feedback_desc']);
$smarty->assign('self_keywords', $seo['feedback_keywords']);
$smarty->display('header.tpl');
$smarty->display('errors.tpl');
$smarty->display('messages.tpl');
$smarty->display('feedback.tpl');
$smarty->display('footer.tpl');
$smarty->gzip_encode();
?>
