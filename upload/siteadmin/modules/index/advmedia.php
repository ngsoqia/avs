<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
Auth::checkAdmin();

$remove         = NULL;
if ( isset($_GET['a']) ) {
    $action = trim($_GET['a']);
    $AID    = ( isset($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    switch ( $action ) {
    case 'delete':
        $sql    = "DELETE FROM adv_media WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $messages[] = 'Media advertise was successfuly deleted!';
        } else {
            $errors[] = 'Failed to delete media advertise! Are you sure this advertise exists?!';
        }
        $remove = '&a=delete&AID=' .$AID;
        break;
    case 'activate':
    case 'suspend':
        $status     = ( $action == 'activate' ) ? 1 : 0;
        $sql        = "UPDATE adv_media SET status = '" .$status. "' WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $messages[] = 'Media advertise was successfuly ' .$action. 'ed!';
        } else {
            $errors[] = 'Failed to ' .$action. ' media advertise! Are you sure this advertise exists?!';
        }
        $remove = '&a=' .$action. '&AID=' .$AID;
        break;
    default:
        $errors[] = 'Invalid action! Allowed actions: delete, activate and suspend!';
    }
}

$query          = constructQuery();
$rs             = $conn->execute($query['count']);
$total_advs     = $rs->fields['total_advs'];
$pagination     = new Pagination($query['items']);
$limit          = $pagination->getLimit($total_advs);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$advs           = $rs->getrows();

function constructQuery()
{
	global $smarty;

    $query              = array();
    $query_count        = "SELECT COUNT(adv_id) AS total_advs FROM adv_media";
    $query_select       = "SELECT * FROM adv_media";
    $query_add          = NULL;
    $option             = array('sort' => 'adv_id', 'order' => 'DESC', 'display' => 20);
    $option             = ( isset($_SESSION['search_media_advertise']) ) ? $_SESSION['search_media_advertise'] : $option;
    if ( isset($_POST['search_media']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        $option['display']  = intval(trim($_POST['display']));

        $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];

        $_SESSION['search_media_advertise'] = $option;
    }

    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count;
    $query['items']     = $option['display'];

    $smarty->assign('option', $option);

    return $query;
}

$smarty->assign('advs', $advs);
$smarty->assign('advs_total', $total_advs);
$smarty->assign('paging', $paging);
?>
