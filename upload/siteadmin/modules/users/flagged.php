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
    if ( $action != '' && $action != 'unflag' && !$UID )
        $errors[] = 'Invalid User ID. User ID must be numeric!';
    switch ( $action ) {
        case 'unflag':
            $FID    = ( isset($_GET['FID']) && is_numeric($_GET['FID']) ) ? intval($_GET['FID']) : NULL;
            $sql    = "DELETE FROM users_flags WHERE flag_id = " .$FID;
            $conn->execute($sql);
            $remove = '&a=unflag&FID=' .$FID;
            $messages[] = 'Successfully unflagged user!';
            break;
        case 'delete':
            deleteUser($UID);
            $remove = '&a=delete&UID=' .$UID;
            $messages[] = 'Successfully deleted user!';
            break;
        case 'activate':
        case 'suspend':
            $act        = ( $action == 'activate' ) ? 'Active' : 'Inactive';
            $act_name   = ( $action == 'activate' ) ? 'activated' : 'suspended';
            $sql = "UPDATE signup SET account_status = '" .$act. "' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'User account ' .$act_name. ' successfuly!';
            $remove = '&a=' .$action. '&UID=' .$UID;
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

function constructQuery()
{
    global $smarty;

    $query              = array();
    $query_count        = "SELECT COUNT(f.UID) AS total_users FROM signup AS u, users_flags AS f WHERE f.UID = u.UID";
    $query_select       = "SELECT u.*, f.RID, f.reason, f.message, f.addtime, f.flag_id
                           FROM signup AS u, users_flags AS f
                           WHERE f.UID = u.UID";
    $query_option       = array();
    $option_orig        = array('username' => '', 'email' => '', 'country' => '', 'name' => '', 'gender' => '', 'relation' => '',
                                'sort' => 'u.UID', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_users_option']);
	}								
								
    $option             = ( isset($_SESSION['search_users_flagged_option']) ) ? $_SESSION['search_users_flagged_option'] : $option_orig;
    
    if ( isset($_POST['search_videos']) ) {
        global $config;
        require $config['BASE_DIR']. '/classes/filter.class.php';
        $filter                 = new VFilter();
        $option['username']     = $filter->get('username');
        $option['email']        = $filter->get('email');
        $option['country']      = $filter->get('country');
        $option['name']         = $filter->get('name');
        $option['gender']       = $filter->get('gender');
        $option['relation']     = $filter->get('relation');
        $option['sort']         = $filter->get('sort');
        $option['order']        = $filter->get('order');
        $option['display']      = $filter->get('display', 'INTEGER');
        
        if ( $option['username'] != '' ) {
            $query_option[] = " AND u.username LIKE '%" .mysql_real_escape_string($option['username']). "%'";
        }

        if ( $option['email'] != '' ) {
            $query_option[] = " AND u.email LIKE '%" .mysql_real_escape_string($option['email']). "%'";
        }

        if ( $option['country'] != '' ) {
            $query_option[] = " AND u.country LIKE '%" .mysql_real_escape_string($option['country']). "%'";
        }
        
        if ( $option['name'] != '' ) {
            $query_option[] = " AND ( u.fname LIKE '%" .mysql_real_escape_string($option['name']). "%' OR u.lname LIKE '%" .mysql_real_escape_string($option['name']). "%'";
        }
        
        if ( $option['gender'] != '' ) {
            $query_option[] = " AND u.gender = '" .mysql_real_escape_string($option['gender']). "'";
        }
        
        if ( $option['relation'] != '' ) {
            $query_option[] = " AND u.relation = '" .mysql_real_escape_string($option['relation']). "'";
        }

        $_SESSION['search_users_flagged_option'] = $option;
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
