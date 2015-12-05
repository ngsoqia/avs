<?php
define('_VALID', true);
define('_ENTER', true);
require 'include/config.php';

setcookie('splash', true, time()+(3600*12*7*52));

$smarty->display('enter.tpl');
$smarty->gzip_encode();
?>
