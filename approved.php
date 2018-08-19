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

// Register error variables

$user_exist = 0;        // Username already taken
$user_length = 0;       // Username length is too short
$password_length = 0;   // Password length is too short
$password_match = 0;    // Passwords do no match
$email_syntax = 0;      // Email syntax is wrong
$email_exist = 0;       // Email already exist
$email_match = 0;       // Email do no match
$user_noone = 0;        // user name contains not one word
$letters_code = 0;

$success_register = 0;  // Successfully registration

// Register form variables
$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$password_repeat = mysql_real_escape_string($_POST['password_repeat']);
$email = mysql_real_escape_string($_POST['email']);
$email_repeat = mysql_real_escape_string($_POST['email_repeat']);
$gender = $_POST['gender'];
$country = $_POST['country'];
$years = mysql_real_escape_string($_POST['years']);
$letters_code_post = $_POST['6_letters_code'];
// If years no set..
if($years == NULL){
  $years = 1900;
}

$birthdate = $years.'-'. $_POST['month'].'-'.$_POST['day'];
////////////////////////////////////////////////////////////

$username_result = mysql_query('SELECT username FROM users WHERE username = "'. $username .'"');
$email_result = mysql_query('SELECT email FROM users WHERE email = "'. $email .'"');

if(mysql_num_rows($username_result )>0){	
	$user_exist = 1;
}

if($letters_code_post != $_SESSION['6_letters_code']) {
    $letters_code = 1;
}


if(strlen($username) < 4){	
	$user_length = 1;
}

if(strlen($password) < 6){	
	$password_length = 1;
}

if($password != $password_repeat){	
	$password_match  = 1;
}

$pattern = "/^([a-z0-9\\+_\\-]+)(\\.[a-z0-9\\+_\\-]+)*@([a-z0-9\\-]+\\.)+[a-z]{2,6}$/ix";
if (preg_match($pattern, $email) == false){
    $email_syntax = 1;
}

if(mysql_num_rows($email_result )>0){	
	$email_exist = 1;
}

if($email != $email_repeat){	
	$email_match  = 1;
}

if(strpos(trim($username), ' ') !== false)
{
    $user_noone = 1;
}

// If error not found, we can register user!
if($user_exist == 0 && $user_length  == 0 && $password_length == 0 && $password_match == 0 && $password_match == 0
&& $email_syntax  == 0 && $email_exist == 0 && $email_match == 0 && $user_noone == 0 && $letters_code == 0){
$password = md5($password);
mysql_query("INSERT INTO users (`username`,`password`,`email`, `avatar`, `gender`,`birthdate`,`country`)
             VALUES ('".$username."','".$password."','".$email."','no_avatar_90x90.gif','".$gender."','".$birthdate."','".$country."')");
	 
	$result = mysql_query("SELECT id FROM users ORDER BY id DESC LIMIT 1;");
	$row = mysql_fetch_array($result);
	$last_id = $row['id'];
mysql_query("INSERT INTO `usebb_members` (`id`,`name`, `email`, `email_show`, `passwd`, `regdate`, `level`, `rank`, `active`, `active_key`, `banned`, `banned_reason`, `last_login`, `last_login_show`, `last_pageview`, `hide_from_online_list`, `posts`, `template`, `language`, `date_format`, `timezone`, `dst`, `enable_quickreply`, `return_to_topic_after_posting`, `target_blank`, `hide_avatars`, `hide_userinfo`, `hide_signatures`, `auto_subscribe_topic`, `auto_subscribe_reply`, `avatar_type`, `avatar_remote`, `displayed_name`, `real_name`, `signature`, `birthday`, `location`, `website`, `occupation`, `interests`, `msnm`, `yahoom`, `aim`, `icq`, `jabber`, `skype`) VALUES
('".$last_id."','".$username."', '".$email."', 0, '".$password."', 0, 1, '', 1, '', 0, '', 0, 0, 0, 0, 0, 'default', 'English', 'D M d, Y g:i a', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 'http://lockframe.net/avatars/no_avatar_90x90.gif', '".$username."', '', '', 0, '', '', '', '', '', '', '', '', '', '')");

$success_register = 1;
}

$array = array('userexist' => $user_exist, 'userlength' => $user_length, 'passwordlength' => $password_length, 'passwordmatch' => $password_match,
'emailsyntax' => $email_syntax, 'emailexist' => $email_exist, 'emailmatch' => $email_match, 'success' => $success_register, 'letters_code'=>$letters_code, 'noone'=>$user_noone);
echo json_encode($array);

?>