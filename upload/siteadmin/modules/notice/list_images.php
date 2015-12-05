<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';

if (isset($_GET['a'])) {
	$action = trim($_GET['a']);
	$id 	= (isset($_GET['CID']) && is_numeric($_GET['CID'])) ? (int) $_GET['CID'] : 0;
	if ($id) {
		switch ($action) {
			case 'delete':
				$sql = "DELETE FROM notice_images WHERE image_id = " .$id. " LIMIT 1";
				$conn->execute($sql);
				@unlink($config['BASE_DIR'].'/images/notice_images/'.$id.'.jpg');
				@unlink($config['BASE_DIR'].'/images/notice_images/thumbs/'.$id.'.jpg');
				$messages[] = 'Image was successfuly delete!';
				break;
			default:
				$errors[] = 'Invalid action!';
				break;
		}
	} else {
		$errors[] = 'Invalid image id! Are you sure this image exists!?';
	}
}

$sql            = "SELECT COUNT(image_id) AS total_images FROM notice_images";
$rs             = $conn->execute($sql);
$images_total   = $rs->fields['total_images'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($images_total);
$paging         = $pagination->getAdminPagination();
$sql            = "SELECT * FROM notice_images ORDER BY addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$images         = $rs->getrows();

$smarty->assign('images', $images);
$smarty->assign('images_total', $images_total);
$smarty->assign('paging', $paging);
?>