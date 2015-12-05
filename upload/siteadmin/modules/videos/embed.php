<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

$video = array('username' => '', 'title' => '', 'category' => 0, 'tags' => '',
               'type' => 'public', 'duration' => '', 'embed_code');
if (isset($_POST['embed_video'])) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter     	= new VFilter();
    $valid			= new VValidation();
	$username		= $filter->get('username');
	$title			= $filter->get('title');
	$tags			= $filter->get('tags');
	$type			= $filter->get('type');
	$category		= $filter->get('category', 'INT');
	$embed_code		= trim($_POST['embed_code']);
	$duration		= $filter->get('duration');
	
    if ( $username == '' ) {
        $errors[]                = 'Please enter a username!';
    } else {
        $sql        = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $rs         = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $uid                = intval($rs->fields['UID']);
            $video['username']  = $username;
        } else {
            $errors[]    = 'Username: ' .htmlspecialchars($username, ENT_QUOTES, 'UTF-8'). 'does not exist!';
        }
    }

    if ( $title == '' ) {
        $errors[]           = 'Please enter a video title!';
    } else {
        $video['title']     = $title;
    }

    if ( $category === 0 ) {
        $errors[]           = 'Please select a video category!';
    } else {
        $video['category']  = $category;
    }

    if ( $tags == '' ) {
        $errors[]           = 'Please enter video tags!';
    } else {
		$tags				= prepare_string($tags, false);
        $video['tags']      = $tags;
    }
	
	if ($embed_code == '') {
		$errors[]			= 'Please enter video embed code!';
	} else {
		$video['embed_code'] = $embed_code;
	}
	
	if ($duration == '') {
		$errors[]			= 'Please enter video duration!';
	} else {
		$video['duration']	= $duration;
	}
	
	$video['type'] = ($type == 'public') ? 'public' : 'private';

	$exts  = array('jpg', 'jpeg');
	$thumb = FALSE;
	foreach ($_FILES as $file) {
		if ($file['tmp_name'] != '') {
			if (is_uploaded_file($file['tmp_name'])) {
				$filename	= substr($file['name'], strrpos($file['name'], DIRECTORY_SEPARATOR)+1);
				$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
				$size		= filesize($file['tmp_name']);
				if (in_array($ext, $exts)) {
					if ($size < (2*1024*1024)) {
						$thumb = TRUE;
					}
				}
			}
		}
	}
	
	if (!$thumb) {
		$errors[]	= 'Please upload at least one video thumb!';
	}
	
	if (!$errors) {
		$sql = "INSERT INTO video
		                SET UID = ".$uid.",
						    title = '".mysql_real_escape_string($title)."',
							keyword = '".mysql_real_escape_string($tags)."',
							channel = '".$category."',
							type = '".$video['type']."',
							embed_code = '".mysql_real_escape_string($embed_code)."',
							duration = ".duration_to_seconds($duration).",
							vkey = '".mt_rand()."',
							addtime = ".time().",
							adddate = '".date('Y-m-d')."',
							active = '0'";
		$conn->execute($sql);
		$vid     = mysql_insert_id();
		require $config['BASE_DIR']. '/classes/image.class.php';
		$image   = new VImageConv();
		$tmb_dir = get_thumb_dir($vid);
		$tmp_dir = $config['BASE_DIR'].'/tmp/thumbs/'.$vid;
		@mkdir($tmb_dir);
		@mkdir($tmp_dir);
		$width	 = (int) $config['img_max_width'];
		$height	 = (int) $config['img_max_height'];
		$i		 = 1;
		foreach ($_FILES as $file) {
			$tmb = $i.'.jpg';
			if (move_uploaded_file($file['tmp_name'], $tmp_dir.'/'.$tmb)) {
				$src     = $tmp_dir.'/'.$tmb;
				$dst 	 = $tmb_dir.'/'.$tmb;
				$dst_tmp = $tmp_dir.'/'.$tmb.'.tmp.jpg';
				$image->process($src, $dst_tmp, 'MAX_WIDTH', $width, 0);
				$image->resize(true, true);
				$image->process($dst_tmp, $dst, 'EXACT', $width, $height);
				$image->crop(0, 0, $width, $height, true);
				++$i;
			}
		}
		
		delete_directory($tmp_dir);
		
		$vkey = substr(md5($vid),11,20);
		$conn->execute("UPDATE video SET vkey = '".$vkey."', thumbs = ".($i-1).", active = '1'
		                WHERE VID = ".$vid." LIMIT 1");
		$messages[] = 'Successfuly embeded video!';
	}

}

function duration_to_seconds($duration)
{
    $dur_arr  = explode(':', $duration);
    if (!isset($dur_arr['1'])) {
        return FALSE;
    }
                    
    $duration = 0;
    if (isset($dur_arr['2'])) {
        $duration = ((int) $dur_arr['2']*3600);
    }

    $duration = $duration + ((int)$dur_arr['0']*60);

    return ($duration + (int)$dur_arr['1']);
}

$smarty->assign('video', $video);
$smarty->assign('categories', get_categories());
?>
