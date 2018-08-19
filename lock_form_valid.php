<?php
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

$lock_link = $_POST['link_input'];
$lock_type = $_POST['type'];

$_SESSION['lock_link'] = $lock_link;


$link_input = 0;
$link_syntax = 0;
$not_logged = 0;



if(strlen($lock_link) == 0){
    $link_input = 1;
}

if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $lock_link) && strlen($lock_link) != 0){
    $link_syntax = 1;
}


if(!isset($_SESSION['username'])){
    $not_logged = 1;
}
$array = array('input' => $link_input, 'syntax' => $link_syntax, 'logged' => $not_logged, 'type' => $lock_type);
echo json_encode($array); 
    


?>