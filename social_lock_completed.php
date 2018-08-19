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

$facebook = $_GET["fb"];
$twitter = $_GET["tw"];
$google = $_GET["g"];
$title = $_GET['title'];
$desc = $_GET['description'];


$lock_link = $_SESSION['lock_link'];
unset($_SESSION['lock_link']);
$owner_id = $_SESSION['ID'];

$duplicate = true;
// That ensure as will not be entries with same code!
while($duplicate){
   $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7); 
   $result = mysql_query('SELECT * FROM links_social WHERE code = "'.$code.'"');
   $count = mysql_num_rows($result);
   if($count < 1){
    $duplicate = false;
   }
}



mysql_query('INSERT INTO links_social (code, link, owner_id, date, facebook, twitter, google, title, description) VALUES ("'.$code .'", "'.$lock_link.'",'.$owner_id.', NOW(),'.$facebook.', '.$twitter.', '.$google.', "'.$title.'", "'.$desc.'")');
header("Location: links.php");
?>