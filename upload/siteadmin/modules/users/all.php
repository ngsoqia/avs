<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

if (isset($_POST['delete_selected_users'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
            if ( $value == 'on' ) {
                deleteUser(str_replace('user_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select users to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) users!';
    }
}

if (isset($_POST['suspend_selected_users']) || isset($_POST['approve_selected_users']) ) {
    $act        = 'Active';
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_users']) ) {
        $act        = 'Inactive';
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
            if ( $value == 'on' ) {
                $uid = intval(str_replace('user_id_checkbox_', '', $key));
                $sql = "UPDATE signup SET account_status = '" .$act. "' WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select users to be ' .$act_name. '!';
    } else {
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) users!';
    }
}

$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $UID    = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? intval(trim($_GET['UID'])) : NULL;    
    $action = trim($_GET['a']);
    if ( $action != '' && !$UID )
        $errors[] = 'Invalid User ID. User ID must be numeric!';
    switch ( $action ) {
        case 'delete':
            deleteUser($UID);
            $remove = '&a=delete&UID=' .$UID;
            $messages[] = 'Successfully deleted user!';
            break;
        case 'activate':
            $sql = "UPDATE signup SET account_status = 'Active' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'User account activated successfuly!';
            $remove = '&a=activate&UID=' .$UID;
            break;
        case 'suspend':
            $sql = "UPDATE signup SET account_status = 'Inactive' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'User account suspended successfuly!';
            $remove = '&a=suspend&UID=' .$UID;
            break;
        default:
            $errors[] = 'Invalid action. Allowed actions: delete, activated and suspend!';
    }
}
$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_users    = $rs->fields['total_users'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_users);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$users          = $rs->getrows();

function constructQuery($module)
{
    global $smarty;

    $query_module = '';
    if ( $module == 'active' or $module == 'inactive' )
            $query_module = " WHERE account_status = '" .$module. "'";

    $query              = array();
    $query_select       = "SELECT * FROM signup" .$query_module;
    $query_count        = "SELECT count(*) AS total_users FROM signup" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $option_orig        = array('username' => '', 'email' => '', 'country' => '', 'name' => '', 'gender' => '', 'relation' => '',
                                'sort' => 'UID', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_users_option']);
	}
	
    $option             = ( isset($_SESSION['search_users_option']) ) ? $_SESSION['search_users_option'] : $option_orig;
    
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['email']        = trim($_POST['email']);
        $option['country']      = trim($_POST['country']);
        $option['name']         = trim($_POST['name']);
        $option['gender']       = trim($_POST['gender']);
        $option['relation']     = trim($_POST['relation']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
        
        if ( $option['username'] != '' ) {
            $query_option[] = $query_add. " username LIKE '%" .mysql_real_escape_string($option['username']). "%'";
            $query_add      = " AND";
        }

        if ( $option['email'] != '' ) {
            $query_option[] = $query_add. " email LIKE '%" .mysql_real_escape_string($option['email']). "%'";
            $query_add      = " AND";
        }

        if ( $option['country'] != '' ) {
            $query_option[] = $query_add. " country LIKE '%" .mysql_real_escape_string($option['country']). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['name'] != '' ) {
            $query_option[] = $query_add. " ( fname LIKE '%" .mysql_real_escape_string($option['name']). "%' OR lname LIKE '%" .mysql_real_escape_string($option['name']). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['gender'] != '' ) {
            $query_option[] = $query_add. " gender = '" .mysql_real_escape_string($option['gender']). "'";
            $query_add      = " AND";
        }
        
        if ( $option['relation'] != '' ) {
            $query_option[] = $query_add. " relation = '" .mysql_real_escape_string($option['relation']). "'";
            $query_add      = " AND";            
        }

        $_SESSION['search_users_option'] = $option;
    }
    
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('users', $users);
$smarty->assign('total_users', $users);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>
