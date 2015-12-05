<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$remove         = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action = trim($_GET['a']);
    $PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? intval(trim($_GET['PID'])) : NULL;
    $FID    = ( isset($_GET['FID']) && is_numeric($_GET['FID']) ) ? intval(trim($_GET['FID'])) : NULL;
    switch ( $action ) {
        case 'unflag':
            $sql    = "DELETE FROM photo_flags WHERE FID = " .$FID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $messages[] = 'Successfully unflaged photo!';
            } else {
                $errors[]   = 'Failed to unflag photo! Are you sure this photo is flagged?!';
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
            $sql        = "UPDATE photos SET status = '" .$status. "' WHERE PID = " .$PID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $messages[] = 'Successfully ' .$perform. ' photo!';
            } else {
                $errors[]   = 'Failed to ' .$action. ' photo! Are you sure this photo exists?!';
            }
            $remove     = '&a=' .$action. '&PID=' .$PID;
            break;
        default:
            $errors[]   = 'Invalid action. Allowed actions: delete, activate, suspend and unflag!';
    }
}

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_photos   = $rs->fields['total_photos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_photos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$photos         = $rs->getrows();

function constructQuery()
{
    global $smarty;

    $query              = array();
    $query_select       = "SELECT p.*, s.username, f.*
                           FROM photos AS p, signup AS s, photo_flags AS f
                           WHERE p.PID = f.PID AND f.UID = s.UID";
    $query_count        = "SELECT COUNT(f.PID) AS total_photos
                           FROM photos AS p, signup AS s, photo_flags AS f
                           WHERE p.PID = f.PID AND f.UID = s.UID";
    $query_option       = array();
    $option_orig        = array('flagger' => '', 'sort' => 'p.PID', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_albums_flagged_option']);
	}
	
	$option             = ( isset($_SESSION['search_albums_flagged_option']) ) ? $_SESSION['search_albums_flagged_option'] : $option_orig;
	
    if ( isset($_POST['search_flags']) ) {

        $option['flagger']      = trim($_POST['flagger']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);

		if ( $option['flagger'] != '' ) {
			$UID                = getUserID($option['flagger']);
			$UID                = ( $UID ) ? intval($UID) : 0;
			$query_option[]     = " AND f.UID = " .$UID;
		}
		
		$_SESSION['search_albums_flagged_option'] = $option;
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

$smarty->assign('photos', $photos);
$smarty->assign('photos_total', $total_photos);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>
