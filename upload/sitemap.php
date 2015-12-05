<?php
define('_VALID', true);
define('_ADMIN', true);
require 'include/config.php';

header("Content-type: text/xml"); 
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.0">'; 

$characters_to_remove = array('&',"'",'"','>','<','-',',','/'); 
$replace_with = array('&amp;','&apos;','&quot;','&gt;','&lt;','','',''); 

$sql 	= "SELECT VID, title, description, thumb FROM video WHERE active = '1' ORDER by addtime DESC LIMIT 20000";
$rs  	= $conn->execute($sql);
$videos = $rs->getrows();
foreach ($videos as $video) {
	$title 	= str_replace($characters_to_remove,$replace_with, $video['title']);
	$desc  	= str_replace($characters_to_remove,$replace_with, strip_tags($description));
	$VID	= $video['VID'];
?>
<url>
    <loc><?php echo $config['BASE_URL'] ?>/video/<?php echo $VID; ?></loc>
    <video:video> 
    <video:thumbnail_loc><?php echo $config['TMB_URL'] ?>/<?php echo $VID; ?>/<?php echo $video['thumb']; ?>.jpg</video:thumbnail_loc> 
    <video:title><?php echo $title ?></video:title> 
    <video:description><?php echo $description ?></video:description> 
    </video:video> 
</url> 
<?php 
} 

echo '</urlset>'; 
?>
