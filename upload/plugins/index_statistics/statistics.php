<?php
defined('_VALID') or die('Restricted Access!');

function plugin_index_statistics()
{
	global $config, $smarty, $conn;
	
	$sql    = "SELECT COUNT(VID) AS total_public_videos FROM video WHERE type = 'public' AND active = '1'";
    $rs     = $conn->execute($sql);
    $smarty->assign('total_public_videos', $rs->fields['total_public_videos']);
    $sql    = "SELECT COUNT(VID) AS total_private_videos FROM video WHERE type = 'private' AND active = '1'";
    $rs     = $conn->execute($sql);
    $smarty->assign('total_private_videos', $rs->fields['total_private_videos']);
    $sql    = "SELECT COUNT(UID) AS total_users FROM signup WHERE account_status = 'Active'";
    $rs     = $conn->execute($sql);
    $smarty->assign('total_users', $rs->fields['total_users']);
    if ( $config['photo_module'] == '1' ) {
        $sql    = "SELECT COUNT(AID) AS total_public_albums FROM albums WHERE type = 'public' AND status = '1'";
        $rs     = $conn->execute($sql);
        $smarty->assign('total_public_albums', $rs->fields['total_public_albums']);
        $sql    = "SELECT COUNT(AID) AS total_private_albums FROM albums WHERE type = 'private' AND status = '1'";
        $rs     = $conn->execute($sql);
		$smarty->assign('total_private_albums', $rs->fields['total_private_albums']);
    }
	if ( $config['game_module'] == '1' ) {
		$sql	= "SELECT COUNT(GID) AS total_public_games FROM game WHERE type = 'public' AND status = '1'";
		$rs		= $conn->execute($sql);
		$smarty->assign('total_public_games', $rs->fields['total_public_games']);
		$sql	= "SELECT COUNT(GID) AS total_private_games FROM game WHERE type = 'private' AND status = '1'";
		$rs		= $conn->execute($sql);
		$smarty->assign('total_private_games', $rs->fields['total_private_games']);
	}
	if ( $config['blog_module'] == '1' ) {
		$sql	= "SELECT COUNT(BID) AS total_blogs FROM blog WHERE status = '1'";
		$rs		= $conn->execute($sql);
		$smarty->assign('total_blogs', $rs->fields['total_blogs']);
	}
	
	$smarty->display($config['BASE_DIR']. '/plugins/index_statistics/statistics.tpl');
}
?>
