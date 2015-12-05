<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$chimg  = $config['BASE_DIR']. '/media/categories/video';
if ( !file_exists($chimg) or !is_dir($chimg) or !is_writable($chimg) ) {
    $errors[] = 'Category image directory \'' .$chimg. '\' is not writable!';
}

$channel    = array();
$CID        = ( isset($_GET['CID']) && is_numeric($_GET['CID']) ) ? trim($_GET['CID']) : NULL;
$CID        = ( $CID && channelExists($CID) ) ? $CID : NULL;
if ( !$CID ) {
    $errors[] = 'Category does not exist! Invalid channel id!?';
}

if ( isset($_POST['edit_channel']) && !$errors ) {
    $name   = trim($_POST['name']);
    
    if ( $name == '' ) {
        $errors[]   = 'Category name field cannot be blank!';
    } 
    
    if ( !$errors ) {
        $sql = "UPDATE channel SET name = '" .mysql_real_escape_string($name). "' WHERE CHID = '" .mysql_real_escape_string($CID). "' LIMIT 1";
        $conn->execute($sql);
        if ( $_FILES['picture']['tmp_name'] != '' ) {
            require $config['BASE_DIR']. '/classes/image.class.php';
            $image = new VImageConv();
            $image->process($_FILES['picture']['tmp_name'], $chimg. '/' .$CID. '.jpg', 'MAX_WIDTH', 384, 216);
            $image->canvas(384, 216, '000000', true);
        }
    }
    
    if ( !$errors ) {
        $messages[] = 'Category updated successfuly!';
    }
}

$sql        = "SELECT * FROM channel WHERE CHID = '" .mysql_real_escape_string($CID). "' LIMIT 1";
$rs         = $conn->execute($sql);
$channel    = $rs->getrows();

$smarty->assign('channel', $channel);
?>
