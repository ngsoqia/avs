<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

if (isset($_POST['delete_selected_cards'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_cards' && substr($key, 0, 17) == 'card_id_checkbox_') {
            if ( $value == 'on' ) {
                deleteCard(str_replace('card_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select cards to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) cards!';
    }
}

$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $id    = ( isset($_GET['id']) && is_numeric($_GET['id']) ) ? intval(trim($_GET['id'])) : NULL;    
    $action = trim($_GET['a']);
    if ( $action != '' && !$id )
        $errors[] = 'Invalid Card ID. Card ID must be numeric!';
    switch ( $action ) {
        case 'delete':
            deleteCard($id);
            $remove = '&a=delete&id=' .$id;
            $messages[] = 'Successfully deleted card!';
            break;
        default:
            $errors[] = 'Invalid action. Allowed actions: delete!';
    }
}
$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_cards    = $rs->fields['total_cards'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_cards);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$cards          = $rs->getrows();

function constructQuery($module)
{
    global $smarty;

    $query_module = '';

    $query              = array();
    $query_select       = "SELECT * FROM user_card" .$query_module;
    $query_count        = "SELECT count(*) AS total_cards FROM user_card" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $option_orig        = array('vip_level' => '', 'used' => '',
                                'sort' => 'id', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_cards_option']);
	}
	
    $option             = ( isset($_SESSION['search_cards_option']) ) ? $_SESSION['search_cards_option'] : $option_orig;
    
    if ( isset($_POST['search_cards']) ) {
        $option['vip_level']     = trim($_POST['vip_level']);
        $option['used']        = trim($_POST['used']);
        $option['card_type']        = trim($_POST['card_type']);
        $option['user_id']        = trim($_POST['user_id']);
        
        if ( $option['vip_level'] != '' ) {
            $query_option[] = $query_add. " vip_level='".$option['vip_level']. "'";
            $query_add      = " AND";
        }

        if ( $option['used'] != '' ) {
            $query_option[] = $query_add. " used='".$option['used']."'";
            $query_add      = " AND";
        }
        if ( $option['card_type'] != '' ) {
            $query_option[] = $query_add. " card_type='".$option['card_type']."'";
            $query_add      = " AND";
        }
        if ( $option['user_id'] != '' ) {
            $query_option[] = $query_add. " user_id='".$option['user_id']."'";
            $query_add      = " AND";
        }

        $_SESSION['search_cards_option'] = $option;
    }
    
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];
    $query['select']        = $query_select . implode(' ', $query_option);
    $query['count']         = $query_count . implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('cards', $cards);
$smarty->assign('total_cards', $cards);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>
