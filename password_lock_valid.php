<?php
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

require_once 'db.php';
$password = $_POST['password'];
$err = 0;

if(strlen($password) < 4){
    $err = 1;
}
else if(strlen($password) > 20){
    $err = 2;
}
else{
	$password = mysql_escape_string($password);
	$owner_id = $_SESSION['ID'];
	$lock_link = $_SESSION['lock_link'];
	unset($_SESSION['lock_link']);
	$duplicate = true;
	// That ensure as will not be entries with same code!
	while($duplicate){
		$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7); 
		$result = mysql_query('SELECT * FROM links_password WHERE code = "'.$code.'"');
		$count = mysql_num_rows($result);
		if($count < 1){
			$duplicate = false;
		}
	}
	mysql_query('INSERT INTO links_password (code, link, owner_id, password, date) VALUES ("'.$code .'", "'.$lock_link.'",'.$owner_id.', "'.$password.'", NOW())');
	
}

$array = array('error' => $err);
echo json_encode($array); 
    


?>