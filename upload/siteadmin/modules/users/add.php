<?php
defined('_VALID') or die('Restricted Access!');

$user = array('username' => '', 'email' => '', 'emailverified' => 'no', 'account_status' => 'Active',
              'fname' => '', 'lname' => '', 'gender' => 'Male');
if ( isset($_POST['add_user']) ) {
	require $config['BASE_DIR']. '/classes/filter.class.php';
	require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
	$username			= $filter->get('username');
    $email              = $filter->get('email');
    $fname              = $filter->get('fname');
    $lname              = $filter->get('lname');
    $gender             = $filter->get('gender');
    $relation           = $filter->get('relation');
	$password           = $filter->get('password');
    $password_confirm   = $filter->get('password_confirm');
	$account_status		= $filter->get('account_status');
    $emailverified      = $filter->get('emailverified');	
	
	if ( $username == '' ) {
		$errors[] = 'Username field cannot be blank!';
	} elseif ( !$valid->username($username) ) {
		$errors[] = 'Username field is not a valid username!';
	} elseif ( $valid->usernameExists($username) ) {
		$errors[] = 'Username is already used by another user!';
	} else {
		$user['username'] = $username;
	}
	
	if ( $email == '' ) {
  		$errors[] = 'Email field cannot be blank!';
    } elseif ( !$valid->email($email) ) {
        $errors[] = 'Email is not a valid email address!';
    } elseif ( $valid->emailExists($email, $UID) ) {
        $errors[] = 'Email is already used by another user!';
    } else {
		$user['email'] = $email;
	}
	
	if ( $password != '' && $password != $password_confirm ) {
  		$errors[] = 'Password and confirmation password are not the same!';
    }

	if ( !$errors ) {
		$user['fname']			= $fname;
		$user['lname']			= $lname;
		$user['gender']			= $gender;
		$user['account_status']	= $account_status;
	
		$sql	= "INSERT INTO signup SET username = '" .mysql_real_escape_string($username). "', email = '" .mysql_real_escape_string($email). "',
		                                  pwd = '" .md5($password). "', fname = '" .mysql_real_escape_string($fname). "',
										  lname = '" .mysql_real_escape_string($lname). "', gender = '" .mysql_real_escape_string($gender). "', 
										  emailverified = '" .mysql_real_escape_string($emailverified). "', account_status = '" .mysql_real_escape_string($account_status). "', 
										  addtime = '" .time(). "', logintime = '" .time(). "'";
		$conn->execute($sql);

        $uid            = mysql_insert_id();
        $sql            = "INSERT INTO users_prefs (UID) VALUES (" .$uid. ")";
        $conn->execute($sql);
        $sql            = "INSERT INTO users_online (UID, online) VALUES (" .$uid. ", " .time(). ")";
        $conn->execute($sql);		
		
		$messages[] = 'User was successfully added!';
		
	}
}

$smarty->assign('user', $user);
?>
