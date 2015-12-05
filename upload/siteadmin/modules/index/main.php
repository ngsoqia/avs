<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/include/config.template.php';
if ( isset($_POST['submit_settings']) ) {
    $filter                 = new VFilter();
    $site_name              = $filter->get('site_name');
    $site_title             = $filter->get('site_title');
    $meta_description       = $filter->get('meta_description');
    $meta_keywords          = $filter->get('meta_keywords');
    $admin_name             = $filter->get('admin_name');
    $admin_pass             = $filter->get('admin_pass');
    $admin_email            = $filter->get('admin_email');
    $noreply_email          = $filter->get('noreply_email');
    $ads                    = $filter->get('ads', 'INTEGER');
    $approve                = $filter->get('approve', 'INTEGER');
    $approve_photos         = $filter->get('approve_photos', 'INTEGER');
    $approve_games          = $filter->get('approve_games', 'INTEGER');
    $approve_blogs          = $filter->get('approve_blogs', 'INTEGER');
    $captcha                = $filter->get('captcha', 'INTEGER');
    $downloads              = $filter->get('downloads', 'INTEGER');
    $gzip_encoding          = $filter->get('gzip_encoding', 'INTEGER');
    $videos_per_page        = $filter->get('videos_per_page', 'INTEGER');
    $albums_per_page        = $filter->get('albums_per_page', 'INTEGER');
    $users_per_page         = $filter->get('users_per_page', 'INTEGER');
    $blogs_per_page         = $filter->get('blogs_per_page', 'INTEGER');
    $watched_per_page       = $filter->get('watched_per_page', 'INTEGER');
    $recent_per_page        = $filter->get('recent_per_page', 'INTEGER');
    $games_per_page         = $filter->get('games_per_page', 'INTEGER');
    $del_original_video     = $filter->get('del_original_video', 'INTEGER');
	$splash					= $filter->get('splash', 'INTEGER');
	$language				= $filter->get('language');
	$multi_language			= $filter->get('multi_language', 'INTEGER');
	$multi_server			= $filter->get('multi_server', 'INTEGER');
    $template				= $filter->get('template');
	$video_embed			= $filter->get('video_embed', 'INTEGER');
	
    if ( $site_name == '' ) {
        $errors[]   = 'Site name field cannot be blank!';
    }
    
    if ( $site_title == '' ) {
        $errors[]   = 'Site title field cannot be blank!';
    }
    
    if ( $meta_description == '' ) {
        $errors[]   = 'Meta description field cannot be blank!';                
    }
    
    if ( $meta_keywords == '' ) {
        $errors[]   = 'Meta keywords field cannot be blank!';
    }
    
    if ( $admin_name == '' ) {
        $errors[]   = 'Admin name (used for siteadmin login) cannot be blank!';
    } elseif ( strlen($admin_name) < 5 ) {
        $errors[]   = 'Admin name (used for siteadmin login) must be at least 6 characters long!';
    }
    
    if ( $admin_pass == '' ) {
        $errors[]   = 'Admin pass (used for siteadmin login) cannot be blank!';
    } elseif ( strlen($admin_pass) < 5 ) {
        $errors[]   = 'Admin pass (used for siteadmin login) must be at least 6 characters long!';
    }
    
    if ( $admin_email == '' ) {
        $errors[]   = 'Admin email field cannot be blank!';
    } elseif ( !VValidation::email($admin_email) ) {
        $errors[]   = 'Admin email field is not a valid email address!';
    }
    
    if ( $noreply_email == '' ) {
        $errors[]   = 'Noreply email field cannot be blank!';
    } elseif ( !VValidation::email($noreply_email) ) {
        $errors[]   = 'Noreply email field is not a valid email address!';
    }
    
    if ( $approve != '1' && $approve != '0' ) {
        $errors[]   = 'Video approve field can only be yes/no!';
    }

    if ( $downloads != '1' && $downloads != '0' ) {
        $errors[]   = 'Video downloads field can only be yes/no!';
    }
    
    if ( $captcha != '1' && $captcha != '0' ) {
        $errors[]   = 'Signup captcha field can only be yes/no!';
    }
    
    if ( $gzip_encoding != '1' && $gzip_encoding != '0' ) {
        $errors[]   = 'GZIP Encoding field can only be yes/no!';
    }
    
    if ( $videos_per_page == '' || $videos_per_page == '0' ) {
        $errors[]   = 'Video Per Page field must be a numeric value!';
    }

    if ( $albums_per_page == '' || $albums_per_page == '0' ) {
        $errors[]   = 'Albums Per Page field must be a numeric value!';
    }

    if ( $users_per_page == '' || $users_per_page == '0' ) {
        $errors[]   = 'Users Per Page field must be a numeric value!';
    }

    if ( $blogs_per_page == '' || $blogs_per_page == '0' ) {
        $errors[]   = 'Blogs Per Page field must be a numeric value!';
    }

    if ( $watched_per_page == '' || $watched_per_page == '0' ) {
        $errors[]   = 'Watched Per Page field must be a numeric value!';
    }

    if ( $recent_per_page == '' || $recent_per_page == '0' ) {
        $errors[]   = 'Recent Per Page field must be a numeric value!';
    }
    
    if ( $del_original_video != '1' && $del_original_video != '0' ) {
        $errors[]   = 'Del original video field can only be yes/no!';
    }
	
	if ($multi_server == '1') {
		$download = 0;
	}
	
    if ( !$errors ) {
        $config['site_name']            = $site_name;
        $config['site_title']           = $site_title;
        $config['meta_description']     = $meta_description;
        $config['meta_keywords']        = $meta_keywords;
        $config['admin_name']           = $admin_name;
        $config['admin_pass']           = $admin_pass;
        $config['admin_email']          = $admin_email;
        $config['noreply_email']        = $noreply_email;
        $config['ads']                  = $ads;
        $config['approve']              = $approve;
        $config['approve_photos']       = $approve_photos;
        $config['approve_games']        = $approve_games;
        $config['approve_blogs']        = $approve_blogs;
        $config['captcha']              = $captcha;
        $config['downloads']            = $downloads;
        $config['gzip_encoding']        = $gzip_encoding;
        $config['videos_per_page']      = $videos_per_page;
        $config['albums_per_page']      = $albums_per_page;
        $config['users_per_page']       = $users_per_page;
        $config['blogs_per_page']       = $blogs_per_page;
        $config['watched_per_page']     = $watched_per_page;
        $config['recent_per_page']      = $recent_per_page;
        $config['games_per_page']       = $games_per_page;
        $config['del_original_video']   = $del_original_video;
		$config['language']				= $language;
		$config['multi_language']		= $multi_language;
		$config['splash']				= $splash;
		$config['multi_server']			= $multi_server;
		$config['template']				= $template;
		$config['video_embed']			= $video_embed;
        update_config($config);
        update_smarty();    
        $messages[] = 'System Settings Updated Successfuly!';
    }
}

$smarty->assign('templates', $templates);
?>
