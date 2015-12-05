<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if (isset($_POST['delete_selected_albums'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_albums' && substr($key, 0, 18) == 'album_id_checkbox_') {
            if ( $value == 'on' ) {
                deleteAlbum(str_replace('album_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select albums to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) albums!';
    }
}

if (isset($_POST['suspend_selected_albums']) || isset($_POST['approve_selected_albums']) ) {
    $act        = 1;
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_albums']) ) {
        $act        = 0;
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_albums' && substr($key, 0, 18) == 'album_id_checkbox_') {
            if ( $value == 'on' ) {
                $aid = intval(str_replace('album_id_checkbox_', '', $key));
                $sql = "UPDATE albums SET status = '" .$act. "' WHERE AID = " .$aid. " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }
    
    if ( $index === 0 ) {
        $errors[]   = 'Please select albumss to be ' .$act_name. '!';
    } else {
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) albums!';
    }
}


$remove = NULL;
if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action = trim($_GET['a']);
    $AID    = ( isset($_GET['AID']) && is_numeric($_GET['AID']) && albumExists($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    if ( $AID ) {
        switch ( $action ) {
            case 'delete':
                deleteAlbum($AID);
                $messages[] = 'Album was successfully removed!';
                $remove = '&a=delete&AID=' .$AID;
                break;
            case 'suspend':
            case 'activate':
                $status = ( $action == 'activate' ) ? 1 : 0;            
                $sql    = "UPDATE albums SET status = '" .$status. "' WHERE AID = " .$AID. " LIMIT 1";
                $conn->execute($sql);
				if ($action == 'activate') {
					send_album_approve_email($AID);
				}
                $messages[] = 'Album was successfully ' .$action. 'ed!';
				if ($action == 'activate')
					$remove='&a=activate&AID=' .$AID;
				else
					$remove='&a=suspend&AID=' .$AID;
                break;
        }
    } else {
        $errors[] = 'Invalid album identifier. Are you sure this album exists!?';
    }
}

$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_albums   = $rs->fields['total_albums'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_albums);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$albums         = $rs->getrows();

function constructQuery($module)
{
    global $smarty;

    $query_module = '';
    if ( $module == 'private' or $module == 'public' ) {
            $query_module = " AND a.type = '" .$module. "'";
    }

    $query              = array();
    $query_select       = "SELECT a.*, s.username FROM albums AS a, signup AS s WHERE a.UID = s.UID" .$query_module;
    $query_count        = "SELECT count(a.AID) AS total_albums FROM albums AS a WHERE a.AID != ''" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $category           = ( isset($_GET['CHID']) && is_numeric($_GET['CHID']) && categoryExists($_GET['CHID']) ) ? intval(trim($_GET['CHID'])) : NULL;
    $option_orig        = array('username' => '', 'name' => '', 'tags' => '', 'category' => $category, 'status' => '',
                                'sort' => 'a.AID', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_albums_option']);
	}
	
	$option             = ( isset($_SESSION['search_albums_option']) ) ? $_SESSION['search_albums_option'] : $option_orig;								
							
    if ( isset($_POST['search_albums']) ) {
        $option['username']     = trim($_POST['username']);
        $option['name']         = trim($_POST['name']);
        $option['tags']         = trim($_POST['tags']);
        $option['category']     = intval(trim($_POST['category']));
        $option['status']       = trim($_POST['status']);
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
			$query_option[] = " AND a.UID = " .$UID;
		}

		if ( $option['name'] != '' ) {
			$query_option[] = " AND a.name LIKE '%" .mysql_real_escape_string($option['name']). "%'";
		}

		if ( $option['tags'] != '' ) {
			$query_option[] = " AND a.tags LIKE '%" .mysql_real_escape_string($option['tags']). "%'";
		}

		if ( $option['category'] != '' ) {
			$query_option[] = " AND a.category = " .intval($option['category']);
		}

		if ( $option['status'] == '0' || $option['status'] == '1' ) {
			$query_option[] = " AND a.status = '" .$option['status']. "'";
		}
		
		$_SESSION['search_albums_option'] = $option;
		
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
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['UID'];
    
    return false;
}

$smarty->assign('albums', $albums);
$smarty->assign('total_albums', $total_albums);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('categories', get_categories());
?>
