<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$remove         = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) ) {
    $action = trim($_GET['a']);
    $NID    = ( isset($_GET['NID']) && is_numeric($_GET['NID']) ) ? intval($_GET['NID']) : NULL;
    switch ( $action ) {
        case 'delete':
            $sql    = "DELETE FROM notice WHERE NID = " .$NID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $messages[] = 'Notice was deleted successfully!';
            } else {
                $errors[]   = 'Failed to delete notice. Are you sure this notice exists?!';
            }
            $remove = '&a=delete&NID=' .$NID;
            break;
        case 'activate':
        case 'suspend':
            $status = ( $action == 'activate' ) ? 1 : 0;
            $sql    = "UPDATE notice SET status = '" .$status. "' WHERE NID = " .$NID. " LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'Successfully ' .$action. 'ed notice!';
            $remove = '&a=' .$action. '&NID=' .$NID;
            break;
    }
}

$query          = constructQuery();
$sql            = $query['count'];
$rsc            = $conn->execute($sql);
$total_notices  = $rsc->fields['total_notices'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_notices);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$notices        = $rs->getrows();

function constructQuery()
{
    global $smarty;

    $query              = array();
    $query_select       = "SELECT * FROM notice";
    $query_count        = "SELECT COUNT(NID) AS total_notices FROM notice";
    $query_add          = " WHERE";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'content' => '',
                                'sort' => 'UID', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_notices_option']);
	}								
								
    $option             = ( isset($_SESSION['search_notices_option']) ) ? $_SESSION['search_notices_option'] : $option_orig;
    
    if ( isset($_POST['search_notices']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['content']      = trim($_POST['content']);
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
            $query_option[] = $query_add. " UID = " .$UID;
            $query_add      = " AND";
        }
        
        if ( $option['title'] != '' ) {
            $query_option[] = $query_add. " title LIKE '%" .mysql_real_escape_string($option['title']). "%'";
            $query_add      = " AND";
        }

        if ( $option['content'] != '' ) {
            $query_option[] = $query_add. " content LIKE '%" .mysql_real_escape_string($option['content']). "%'";
            $query_add      = " AND";
        }
		
		$_SESSION['search_notices_option'] = $option;
    }
    
    $query_sort             = " ORDER BY " .$option['sort']. " " .$option['order'];
    $query['select']        = $query_select .implode(' ', $query_option) . $query_sort;
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
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['UID'];

    return false;
}

$smarty->assign('notices', $notices);
$smarty->assign('notices_total', $total_notices);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>
