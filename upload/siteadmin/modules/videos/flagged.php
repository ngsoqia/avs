<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$remove         = NULL;
if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action = trim($_GET['a']);
    $VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? intval(trim($_GET['VID'])) : NULL;
    $FID    = ( isset($_GET['FID']) && is_numeric($_GET['FID']) ) ? intval(trim($_GET['FID'])) : NULL;
    switch ( $action ) {
        case 'unflag':
            $sql    = "DELETE FROM video_flags WHERE FID = " .$FID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $messages[] = 'Successfully unflaged video!';
            } else {
                $errors[]   = 'Failed to unflag video! Are you sure this video is flagged?!';
            }
            $remove = '&a=unflag&FID=' .$FID;
            break;
        case 'activate':
        case 'suspend':
            if ( $action == 'activate' ) {
                $status = 1;
                $perform    = 'activated';
            } else {
                $status     = 0;
                $perform    = 'suspended';
            }
            $sql        = "UPDATE video SET active = '" .$status. "' WHERE VID = " .$VID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                if ( $status === 1 ) {
                    send_video_approve_email($VID);
                }
                $messages[] = 'Successfully ' .$perform. ' video!';
            } else {
                $errors[]   = 'Failed to ' .$action. ' video! Are you sure this video exists?!';
            }
            $remove     = '&a=' .$action. '&VID=' .$VID;
            break;
        default:
            $errors[]   = 'Invalid action. Allowed actions: delete, activate, suspend and unflag!';
    }
}

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_videos   = $rs->fields['total_videos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_videos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();

function constructQuery()
{
    global $smarty;

    $query              = array();
    $query_select       = "SELECT v.*, s.username, f.UID AS SUID, f.FID, f.add_date, f.reason, f.message
                           FROM video AS v, signup AS s, video_flags AS f
                           WHERE v.VID = f.VID AND v.UID = s.UID";
    $query_count        = "SELECT COUNT(f.VID) AS total_videos FROM video AS v, signup AS s, video_flags AS f
                           WHERE v.VID = f.VID AND v.UID = s.UID";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'flagger' => '', 'sort' => 'v.VID', 'order' => 'DESC', 'display' => 10);
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_videos_flagged_option']);
	}
	
	$option             = ( isset($_SESSION['search_videos_flagged_option']) ) ? $_SESSION['search_videos_flagged_option'] : $option_orig;	
	
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['flagger']      = trim($_POST['flagger']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);

		if ( $option['username'] != '' || isset($_GET['UID']) ) {
			if ( $option['username'] != '' ) {
				$UID            = getUserID($option['username']);
			} else {
				$UID            = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
			}
			$UID            = ( $UID ) ? intval($UID) : 0;
			$query_option[] = " AND v.UID = " .$UID;
		}
		
		if ( $option['flagger'] != '' ) {
			$UID                = getUserID($option['flagger']);
			$UID                = ( $UID ) ? intval($UID) : 0;
			$query_option[]     = " AND f.UID = " .$UID;
		}
									
		if ( $option['title'] != '' ) {
			$query_option[] = " AND v.title LIKE '%" .mysql_real_escape_string($option['title']). "%'";
		}

		$_SESSION['search_videos_flagged_option'] = $option;
    }
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    $smarty->assign('option', $option);

    return $query;
}
 
function getUserID( $username )
{
    global $conn;
        
    $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['UID'];
    }

    return false;
}

$smarty->assign('videos', $videos);
$smarty->assign('videos_total', $total_videos);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>
