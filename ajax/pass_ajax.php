<?php
    
require_once '../db.php';
$link = 'none';
$password = $_POST['password'];
$code = $_POST['code'];
$password_result = '';
$visitor_ip = $_SERVER['REMOTE_ADDR'];

$results = mysql_query("SELECT password FROM links_password WHERE code = '".$code."'");

while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
	$password_result = $row['password'];
}

if($password_result == $password){
	mysql_query("INSERT password_links_unlock (ip, code) VALUES  ('".$visitor_ip."','".$code."');");
	$array = array('error' => 0);
	echo json_encode($array); 
}else{
	$array = array('error' => 1);
	echo json_encode($array); 
}

?>