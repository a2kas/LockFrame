<?php
require_once 'db.php';
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}


if(!isset($_SESSION['ID'])) {
	header('Location: index.php');
	die();
}
$user_id = $_SESSION['ID'];

$_genderList = array('Not set', 'Male', 'Female');

$email = $_POST['email'];
$gender = $_POST['gender'];
$country = $_POST['country'];
$years = mysql_real_escape_string($_POST['years']);
$_POST['years'] = preg_replace("/[^0-9]/", "", $_POST['years']);
$_POST['month'] = preg_replace("/[^0-9]/", "", $_POST['month']);
$_POST['day'] = preg_replace("/[^0-9]/", "", $_POST['day']);
$birthdate = $years.'-'. $_POST['month'].'-'.$_POST['day'];
//echo 'UPDATE users SET email = "'. $email.'", gender = "'. $gender .'", country = "'. $country .'", birthdate = "'. $birthdate .'" WHERE id = "'. $user_id .'"';

if(empty($gender) || empty($country) || empty($email) || empty($years) || empty($user_id)) {
	header('Location: profile.php?err=Please fill empty inputs.&success=&action=');
	die();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('Location: profile.php?err=Invalid email address&success=&action=');
	die();
} 

$user = $DB->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
$user->bindParam(':email', $_GET['email'], PDO::PARAM_STR, 100);
$user->execute();
$user = $user->fetch();
if(isset($_POST['pass']{0}) & isset($_POST['pass2'])) {


	if($_POST['pass'] != $_POST['pass2']) {
		header('Location: profile.php?err=Sorry, passwords didint matched.&success=&action=');
		die();
	}

	if(strlen($_POST['pass']) < 6 || strlen($_POST['pass']) > 10) {
		header('Location: profile.php?err=Sorry, password should be between 6 and 10 symbols.&success=&action=');
		die();
	}
	mysql_query('UPDATE users SET password="'.md5($_POST['pass']).'" WHERE id = "'. $user_id .'"');
	mysql_query('UPDATE usebb_members SET passwd="'.md5($_POST['pass']).'" WHERE id = "'. $user_id .'"');
}

if(!empty($user) & $user->ID != $user_id) {
	header('Location: profile.php?err=Sorry, email is already in use.&success=&action=');
	die();
}

if(!in_array($gender,$_genderList)) {
	header('Location: profile.php?err=Please choose valid gender.&success=&action=');
	die();	
}

if($_POST['years'] <= 1900 || $_POST['years'] > date("Y")){
	header('Location: profile.php?err=Please type valid years.&success=&action=');
	die();
}




mysql_query('UPDATE users SET email = "'. $email.'", gender = "'. $gender .'", country = "'. $country .'", birthdate = "'. $birthdate .'" WHERE id = "'. $user_id .'"');
mysql_query('UPDATE usebb_members SET email = "'. $email.'" WHERE id = "'. $user_id .'"');
header('Location: profile.php?err=&success=Information updated.&action=');
die();




?>

