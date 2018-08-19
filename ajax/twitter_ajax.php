<?php
require_once '../db.php';
$b_tw = $_POST['tw'];
$code = $_POST['code'];
$visitor_ip = $_POST['ip'];

if(isset($b_tw) && isset($code) && isset($visitor_ip)){
    mysql_query("UPDATE social_links_unlock SET twitter = ".$b_tw." WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
}

?>

