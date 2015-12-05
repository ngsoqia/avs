<?php
defined('_VALID') or die('Restricted Access!');
function plugin_photo_ptag_cloud()
{
	global $config, $smarty, $conn;
	$sql 	= "SELECT tags FROM albums
	      	   WHERE status = '1'
			   ORDER BY total_views DESC
			   LIMIT 20";
	$rs  	= $conn->execute($sql);
	$rows	= $rs->getrows();
	$tags 	= array();
	foreach ($rows as $row) {
		$tag_arr = explode(' ', $row['tags']);
		foreach ($tag_arr as $tag) {
			if (mb_strlen($tag) > 2) {
				if (isset($tags[$tag]) && $tags[$tag] <= 10) {
					$tags[$tag] = (int)$tags[$tag]+1;
				} else {
					$tags[$tag] = 1;
				}
			}
		}
	}
	
	$smarty->assign('tags', $tags);
	$smarty->display($config['BASE_DIR']. '/plugins/photo_ptag_cloud/ptag_cloud.tpl');
}
?>
