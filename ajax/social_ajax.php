<?php
    
require_once '../db.php';
$b_fb = $_POST['fb'];
$b_tw = $_POST['tw'];
$b_g = $_POST['g'];
$code = $_POST['code'];
$visitor_ip = $_POST['ip'];
$link = 'none';

$b_unlock_fb = 0;
$b_unlock_tw = 0;
$b_unlock_g = 0;

if(isset($b_tw) && isset($code) && isset($visitor_ip)){
    mysql_query("UPDATE social_links_unlock SET twitter = 1 WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
}	
if(isset($b_fb) && isset($code) && isset($visitor_ip)){
    mysql_query("UPDATE social_links_unlock SET facebook =1 WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
}	
if(isset($b_g) && isset($code) && isset($visitor_ip)){
    mysql_query("UPDATE social_links_unlock SET google = 1 WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
}

$links_social_result = mysql_query("SELECT * FROM links_social WHERE code = '".$code."'");
$social_links_unlock_result = mysql_query("SELECT * FROM social_links_unlock WHERE ip = '".$visitor_ip."' AND code = '".$code."'");

while ($row = mysql_fetch_array($links_social_result, MYSQL_ASSOC)) {
	$link = $row['link'];      // Užrakinta nuoroda
	$b_fb = $row['facebook'];  // Facebook loginis kintamasis
	$b_tw = $row['twitter'];   // Twitter loginis kintamasis
	$b_g =  $row['google'];    // Google loginis kintamasis
}

while ($row = mysql_fetch_array($social_links_unlock_result, MYSQL_ASSOC)) {
	$b_unlock_fb = $row['facebook'];  // Facebook loginis kintamasis
	$b_unlock_tw = $row['twitter'];   // Twitter loginis kintamasis
	$b_unlock_g =  $row['google'];    // Google loginis kintamasis
}

if( $b_unlock_fb == 1 && $b_unlock_tw == 1 &&  $b_unlock_g == 1)
{
	echo $link;
}
else
{
	echo 'none';
}
?>