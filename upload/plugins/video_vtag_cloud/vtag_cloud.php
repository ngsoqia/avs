<?php
defined('_VALID') or die('Restricted Access!');
function plugin_video_vtag_cloud()
{
	global $config, $smarty, $conn;
	$sql 	= "SELECT keyword FROM video
	      	   WHERE active = '1'
			   ORDER BY viewnumber DESC
			   LIMIT 20";
	$rs  	= $conn->execute($sql);
	$rows	= $rs->getrows();
	$tags 	= array();
	foreach ($rows as $row) {
		$tag_arr = explode(' ', $row['keyword']);
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
	$smarty->display($config['BASE_DIR']. '/plugins/video_vtag_cloud/vtag_cloud.tpl');
}
?>
