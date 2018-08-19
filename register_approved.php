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
$letters_code = $_POST['6_letters_code'];
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

if($letters_code != $_SESSION['6_letters_code']) {
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

// If error not found, we can register user!
if($user_exist == 0 && $user_length  == 0 && $password_length == 0 && $password_match == 0 && $password_match == 0
&& $email_syntax  == 0 && $email_exist == 0 && $email_match == 0 && $letters_code == 0){
$password = md5($password);
mysql_query("INSERT INTO users (`username`,`password`,`email`, `avatar`, `gender`,`birthdate`,`country`, `name`, `passwd`)
             VALUES ('".$username."','".$password."','".$email."','no_avatar_90x90.gif','".$gender."','".$birthdate."','".$country."','".$username."','".$password."')");
$success_register = 1;
}

$array = array('userexist' => $user_exist, 'userlength' => $user_length, 'passwordlength' => $password_length, 'passwordmatch' => $password_match,
'emailsyntax' => $email_syntax, 'emailexist' => $email_exist, 'emailmatch' => $email_match, 'success' => $success_register, 'letters_code' => $letters_code);
echo json_encode($array);

?>