<?php
defined('_VALID') or die('Restricted Access!');

if ( isset($_GET['a']) ) {
    $action         = trim($_GET['a']);
    $category_id    = ( isset($_GET['CID']) && is_numeric($_GET['CID']) ) ? intval($_GET['CID']) : NULL;
    switch ( $action ) {
        case 'delete':
            $sql    = "DELETE FROM notice_categories WHERE category_id = " .$category_id. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $messages[] = 'Category was sucessfully deleted!';
            } else {
                $errors[]   = 'Failed to delete category!';
            }
            break;
        case 'activate':
        case 'suspend':
            $status = ( $action == 'activate' ) ? 1 : 0;
            $sql    = "UPDATE notice_categories SET status = '" .$status. "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'Successfully ' .$action. 'ed category!';
            break;
    }
}

if ( isset($_POST['add_category']) ) {
    $name  = trim($_POST['category_name']);
    
    if ( $name == '' ) {
        $errors[]   = 'Category name field cannot be blank!';
    } elseif ( strlen($name) > 199 ) {
        $errors[]   = 'Category name field cannot be longer then 199 characters!';
    } else {    
        $sql            = "SELECT category_id FROM notice_categories WHERE name = '" .mysql_real_escape_string($name). "' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $errors[]   = 'Category name is already used. Please try another category name!';
        }
    }
    
    if ( !$errors ) {
        $sql        = "INSERT INTO notice_categories SET name = '" .mysql_real_escape_string($name). "'";
        $conn->execute($sql);
        $messages[] = 'Category was successfully added!';
    }
}

$sql        = "SELECT * FROM notice_categories ORDER BY name DESC";
$rs         = $conn->execute($sql);
$categories = $rs->getrows();

$smarty->assign('categories', $categories);
?>
