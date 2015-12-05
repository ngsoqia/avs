<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';

if ( isset($_POST['profile_submit']) ) {
    $filter             = new VFilter();
    $password           = $filter->get('password');
    $password_confirm   = $filter->get('password_confirm');
    $fname              = $filter->get('fname');
    $lname              = $filter->get('lname');
    $gender             = $filter->get('gender');
	$bday				= $filter->get('bday');
    //$birth_month        = $filter->get('Date_Month', 'INTEGER');
    //$birth_day          = $filter->get('Date_Day', 'INTEGER');
    //$birth_year         = $filter->get('Date_Year', 'INTEGER');
    $relation           = $filter->get('relation');
    $interested         = $filter->get('interested');
    $website            = $filter->get('website');
    $town               = $filter->get('town');
    $city               = $filter->get('city');
    $country            = $filter->get('country');
    $occupation         = $filter->get('occupation');
    $company            = $filter->get('company');
    $school             = $filter->get('school');
    $aboutme            = $filter->get('aboutme');
    $interest_hobby     = $filter->get('interest_hobby');
    $fav_movie_show     = $filter->get('fav_movie_show');
    $fav_music          = $filter->get('fav_music');
    $fav_book           = $filter->get('fav_book');    
    $turnon             = $filter->get('turnon');
    $turnoff            = $filter->get('turnoff');

	$birth_month = date("m", strtotime($bday));
	$birth_day   = date("d", strtotime($bday));
	$birth_year  = date("Y", strtotime($bday));
    
    $sql_add            = NULL;
    if ( $password != '' ) {
        if ( $password != $password_confirm ) {
            $errors[]   = $lang['signup.password_mismatch'];
			$err['password'] = 1;
        } else {
			$password	= md5($password);
            $sql_add   .= ", pwd = '" .mysql_real_escape_string($password). "'";
        }
    }
    
    if ( $birth_month !='' && $birth_day != '' && $birth_year != '' ) {
        require $config['BASE_DIR']. '/classes/validation.class.php';
        $valid  = new VValidation();
        if ( !$valid->date($birth_month, $birth_day, $birth_year) ) {
            $errors[]   = $lang['user.birthdate_invalid'];
			$err['bday'] = 1;
        } else {
            $birth_date = $birth_year. '-' .$birth_month. '-' .$birth_day;
            $sql_add   .= ", bdate = '" .mysql_real_escape_string($birth_date). "'";
        }
    }
    
    if ( !$errors ) {
        $sql            = "UPDATE signup SET fname = '" .mysql_real_escape_string($fname). "', lname = '" .mysql_real_escape_string($lname). "',
                                             gender = '" .mysql_real_escape_string($gender). "', relation = '" .mysql_real_escape_string($relation). "',
                                             interested = '" .mysql_real_escape_string($interested). "', website = '" .mysql_real_escape_string($website). "',
                                             town = '" .mysql_real_escape_string($town). "', city = '" .mysql_real_escape_string($city). "',
                                             country = '" .mysql_real_escape_string($country). "', aboutme = '" .mysql_real_escape_string($aboutme). "',
                                             fav_movie_show = '" .mysql_real_escape_string($fav_movie_show). "', fav_music = '" .mysql_real_escape_string($fav_music). "',
                                             fav_book = '" .mysql_real_escape_string($fav_book). "', turnon = '" .mysql_real_escape_string($turnon). "',
                                             turnoff = '" .mysql_real_escape_string($turnoff). "', occupation = '" .mysql_real_escape_string($occupation). "',
                                             company = '" .mysql_real_escape_string($company). "', school = '" .mysql_real_escape_string($school). "',
                                             interest_hobby = '" .mysql_real_escape_string($interest_hobby). "'" .$sql_add. "
                          WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $conn->execute($sql);
        $messages[]     = 'Profile was successfully updated!';
    }
}

$sql            = "SELECT fname, lname, bdate, relation, interested, town, city, country, occupation, company, school,
                          aboutme, interest_hobby, fav_movie_show, fav_music, fav_book, turnon, turnoff, website
                   FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
$rs             = $conn->execute($sql);
$profile        = $rs->getrows();
$profile        = $profile['0'];
$user           = array_merge($user, $profile);
$bdate          = explode('-', $user['bdate']);
$byear          = $bdate['0'];
$bmonth         = $bdate['1'];
$bday           = $bdate['2'];
//$user['bdate']  = mktime(0, 0, 0, $bmonth, $bday, $byear);
?>
