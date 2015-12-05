<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$album = array('username' => 'anonymous', 'name' => '', 'tags' => '', 'category' => 0,
               'type' => 'public');
if ( isset($_POST['add_album']) ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $filter             = new VFilter();
    $username           = $filter->get('username');
    $name               = $filter->get('name');
    $tags               = $filter->get('tags');
    $category           = $filter->get('category', 'INTEGER');
    $type               = $filter->get('type');

    if ( $username == '' ) {
        $errors[]   = 'Please add a username for your game!';
    } else {
        $sql        = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $rs         = $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $uid                = intval($rs->fields['UID']);
            $album['username']  = $username;
        } else {
            $errors[] = 'Invalid username. Are you sure this username exists?!';
        }
    }

    if ( $name == '' ) {
        $errors[]   = 'Album name field cannot be blank!';
    } elseif ( strlen($name) < 3 ) {
        $errors[]   = 'Album title field must contain at least 3 characters and no more then 99!';
    } else {
        $album['name'] = $name;
    }

    if ( $tags == '' ) {
        $errors[]   = 'Album title field cannot be left blank!';
    } elseif ( strlen($tags) > 3 ) {
        $error[]    = 'Album title field must contain at least 3 characters and no more then 299!';
    } else {
        $album['tags'] = $tags;
    }

    if ( $category === 0 ) {
        $errors[]   = 'Please select a category!';
    } else {
        $album['category'] = $category;
    }
    
    if ( $_FILES['photo_1']['tmp_name'] == '' ) {
        $errors[]   = 'Please select at least one photo for your album!';
    } elseif ( !is_uploaded_file($_FILES['photo_1']['tmp_name']) ) {
        $errors[]   = 'First album photo is not a valid uploaded file!';
    }
    
    if ( !$errors ) {
        require $config['BASE_DIR']. '/classes/image.class.php';
        $album['type']  = ( $type == 'public' ) ? 'public' : 'private';
        $sql            = "INSERT INTO albums (UID, name, category, tags, type, addtime, adddate, status) 
                           VALUES (" .$uid. ", '" .mysql_real_escape_string($name). "', " .$category. ", 
                                   '" .mysql_real_escape_string($tags). "', '" .$type. "', " .time(). ", '" .date('Y-m-d'). "', '1')";
        $conn->execute($sql);
        $album_id   = mysql_insert_id();
        $photos     = 0;
        $image      = new VImageConv();
        foreach ( $_FILES as $key => $values ) {
            if ( $values['tmp_name'] != '' ) {
                if ( is_uploaded_file($values['tmp_name']) ) {
                    ++$photos;
                    $photo_expl     = explode('_', $key);
                    $photo_nr       = $photo_expl['1'];
                    $caption        = $filter->get('caption_' .$photo_nr);
                    $sql_add        = NULL;
                    if ( $caption != '' ) {
                        $sql_add    = ", caption = '" .mysql_real_escape_string($caption). "'";
                    }

                    $sql            = "INSERT INTO photos SET AID = " .$album_id . $sql_add;
                    $conn->execute($sql);
                    $photo_id       = mysql_insert_id();
					
                    $src            = $values['tmp_name'];
                    $dst            = $config['BASE_DIR']. '/media/photos/tmb/' .$photo_id. '.jpg';

					list ($width, $height) = getimagesize($src);
					$crop_w = min ($width, $height);
					$crop_h = $crop_w;
					if ($width > $height) {
						$crop_x = floor (($width - $crop_w)/2);
						$crop_y = 0;
					}
					else {
						$crop_x = 0;
						$crop_y = floor (($height - $crop_h)/2);
					}			
					
					$image->process($src, $dst, 'EXACT', $crop_w, $crop_h);
					$image->crop($crop_x, $crop_y, $crop_w, $crop_h, true);
					$image->process($dst, $dst, 'MAX_WIDTH', 400, 0);
					$image->resize(true, true);
					

                    $dst        = $config['BASE_DIR']. '/media/photos/' .$photo_id. '.jpg';
                    $image->process($src, $dst, 'MAX_WIDTH', 960, 0);
                    $image->resize(true, true);
                }
            }
        }
        
        $src        = $config['BASE_DIR']. '/media/photos/tmb/' .$photo_id. '.jpg';
        $dst        = $config['BASE_DIR']. '/media/albums/' .$album_id. '.jpg';
        $image->process($src, $dst, 'MAX_WIDTH', 400, 0);
        $image->resize(true, true);
		
        $sql        = "UPDATE albums SET total_photos = " .intval($photos). ", status = '1' WHERE AID = " .$album_id. " LIMIT 1";
        $conn->execute($sql);
        $sql        = "UPDATE channel SET total_albums = total_albums+1 WHERE CHID = " .$category. " LIMIT 1";
        $conn->execute($sql);
        $sql        = "UPDATE signup SET total_albums = total_albums+1 WHERE UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);

        $messages[] = 'Album was successfully added!';
    }
}

$smarty->assign('album', $album);
$smarty->assign('categories', get_categories());
?>