<?php

ob_start();
require_once 'db.php';
//require 'forum/sources/session.php';
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';

$login_error = 1;
$username = mysql_real_escape_string($_POST['username_login']);
$password = mysql_real_escape_string($_POST['password_login']);
//$username = mysql_real_escape_string($_GET['username_login']);
//$password = mysql_real_escape_string($_GET['password_login']);
$password = md5($password);

$result = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");
$count = mysql_num_rows($result);
$row = mysql_fetch_array($result);

if($count == 1)
{
    $_SESSION['ID'] = $row['id']; 
    $_SESSION['username'] = $username; 
    $result = mysql_query("SELECT * FROM usebb_members WHERE name='$username' AND passwd='$password'");
    $row = mysql_fetch_array($result);
    $session->update(NULL, $row['id']);
    $functions->set_al($row['id'], $row['passwd']);

    $login_error = 0;
} else {
    $login_error = 1;

}
$array = array('loginerror' => $login_error);
echo json_encode($array);

?>