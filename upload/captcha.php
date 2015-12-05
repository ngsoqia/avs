<?php
define('_VALID', true);
require 'include/config.paths.php';
require 'include/config.db.php';
require 'include/config.local.php';
require 'include/sessions.php';

header('Expires: Mon, 1 Jan 2001 00:00:00 GMT');
header('Last-Modified: ' .gmdate('D, d M Y H:i:s'). ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0');
header('Pragma: no-cache');

require 'classes/captcha.class.php';
$captcha = new VCaptcha(170, 50);
$captcha->generate();
?>
