<?php
require_once '../db.php';


$code = isset($_GET['code'])?$_GET['code']:'';
$visitor_ip = isset($_GET['ip'])?$_GET['ip']:'';
$links = mysql_fetch_assoc(mysql_query("SELECT * FROM links_social WHERE code = '".$code."'"));
$social_links = mysql_fetch_assoc(mysql_query("SELECT * FROM social_links_unlock WHERE ip = '".$visitor_ip."' AND code = '".$code."'"));

if($links['facebook'] == $social_links['facebook'] & $links['twitter'] == $social_links['twitter'] & $links['google'] == $social_links['google']) {
	die(json_encode(array('err'=>'ok','link'=>$links['link'])));
}
die(json_encode(array('err'=>'bad')));



?>