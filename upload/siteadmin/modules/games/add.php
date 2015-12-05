<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$game  = array('username' => 'anonymous', 'title' => '', 'tags' => '', 'category' => 0, 'type' => 'public',
               'be_commented' => 'yes', 'be_rated' => 'yes', 'status' => 1);                              
if ( isset($_POST['add_game']) ) {
    $username           = trim($_POST['username']);
    $title              = trim($_POST['title']);
    $tags               = trim($_POST['tags']);
    $category           = intval(trim($_POST['category']));
    $type               = trim($_POST['type']);
    $be_commented       = trim($_POST['be_commented']);
    $be_rated           = trim($_POST['be_rated']);
    
    if ( $username == '' ) {
        $errors[]   = 'Please add a username for your game!';
    } else {
        $sql        = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $rs         = $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $uid    = intval($rs->fields['UID']);
        } else {
            $errors[] = 'Invalid username. Are you sure this username exists?!';
        }
    }
    
    if ( $title == '' ) {
        $errors[]   = 'Game title field cannot be blank!';
    } elseif ( strlen($title) < 3 ) {
        $errors[]   = 'Game title field must contain at least 3 characters and no more then 99!';
    } else {
        $game['title'] = $title;
    }
    
    if ( $tags == '' ) {
        $errors[]   = 'Game title field cannot be left blank!';
    } elseif ( strlen($tags) > 3 ) {
        $error[]    = 'Game title field must contain at least 3 characters and no more then 299!';
    } else {
        $game['tags'] = $tags;
    }
    
    if ( $category === 0 ) {
        $errors[]   = 'Please select a category!';
    } else {
        $game['category'] = $category;
    }
    
    if ( !$errors ) {
        if ( $_FILES['game_file']['tmp_name'] == '' ) {
            $errors[]   = 'Please select a game file!';
        } elseif ( !is_uploaded_file($_FILES['game_file']['tmp_name']) ) {
            $errors[]   = 'Game file is not a valid uploaded file!';
        } else {
            $filename           = substr($_FILES['game_file']['name'], strrpos($_FILES['game_file']['name'], DIRECTORY_SEPARATOR)+1);
            $extension          = strtolower(substr($filename, strrpos($filename, '.')+1));
            $extensions_allowed = explode(',', $config['game_allowed_extensions']);
            if ( !in_array($extension, $extensions_allowed) ) {
                $errors[]       = 'Invalid game extension! Allowed extensions: ' .$config['game_allowed_extensions']. '!';
            } else {
                $space = filesize($_FILES['game_file']['tmp_name']);
                if ( $space > ($config['game_max_size']*1024*1024) ) {
                    $errors[]   = 'File exceeds maximum allowed game filesize of ' .$config['game_max_size']. 'MB!';
                }
            }
        }
        
        if ( $_FILES['game_thumb']['tmp_name'] == '' ) {
            $errors[]   = 'Please select a game thumb file!';
        } elseif ( !is_uploaded_file($_FILES['game_thumb']['tmp_name']) ) {
            $errors[]   = 'Game thumb file is not a valid uploaded file!';
        } else {
            $tmb_filename           = substr($_FILES['game_thumb']['name'], strrpos($_FILES['game_thumb']['name'], DIRECTORY_SEPARATOR)+1);
            $tmb_extension          = strtolower(substr($tmb_filename, strrpos($tmb_filename, '.')+1));
            $tmb_allowed_extensions = explode(',', $config['image_allowed_extensions']);
            if ( !in_array($tmb_extension, $tmb_allowed_extensions) ) {
                $errors[]           = 'Invalid game thumb image extension!';
            } else {
                $tmb_size = filesize($_FILES['game_thumb']['tmp_name']);
                if ( $tmb_size > $config['image_max_size'] ) {
                    $errors[]       = 'Game thumb file exceeds maximum allowed image filesize of ' .$config['image_max_size']. 'MB!';
                }
            }
        }
    }    
        
    if ( !$errors ) {
        $game['type']           = ( $type == 'private' ) ? 'private' : 'public';
        $game['be_commented']   = ( $be_commented == 'yes' ) ? 'yes' : 'no';
        $game['be_rated']       = ( $be_rated == 'yes' ) ? 'yes' : 'no';
    
        $sql    = "INSERT INTO game SET UID = " .$uid. ", title = '" .mysql_real_escape_string($title). "', 
                           category = " .$category. ", tags = '" .mysql_real_escape_string($tags). "', 
                           space = '" .$space. "', addtime = '" .time(). "', adddate = '" .date('Y-m-d'). "', 
                           type = '" .$game['type']. "', be_commented = '" .$be_commented. "',
                           be_rated = '" .$be_rated. "', status = '1'";
        $conn->execute($sql);
        $game_id = mysql_insert_id();
        $game_file  = $game_id. '.swf';
        $game_path  = $config['BASE_DIR']. '/media/games/swf/' .$game_file;
        if ( !move_uploaded_file($_FILES['game_file']['tmp_name'], $game_path) ) {
            $errors[] = 'Failed to move uploaded game file!';
        } else {
            require $config['BASE_DIR']. '/classes/image.class.php';
            $src    = $_FILES['game_thumb']['tmp_name'];
            $dst    = $config['BASE_DIR']. '/media/games/tmb/' .$game_id. '.jpg';
            $image  = new VImageConv();
            $image->process($src, $dst, 'MAX_WIDTH', 256, 144);
            $image->canvas(256, 144, '000000', true);                
            $messages[] = 'Game was successfully added!';
        }
    }
}

$sql = "SELECT * FROM game_categories ORDER BY category_name ASC";
$rs  = $conn->execute($sql);

$smarty->assign('game', $game);
$smarty->assign('categories', $rs->getrows());
?>
