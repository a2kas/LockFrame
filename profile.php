<?php

define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

if(isset($_SESSION['ID']) == false)
	header("Location: http://www.lockframe.net");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="description" content="Online Affiliate Tool">
<meta name="keywords" content="Affiliate, Advertisement, Lock, Banner, Share">
<meta name="author" content="LockFrame">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>LockFrame - Online Affiliate Tool</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="js/javascripts.js"></script>
</head>

<body>
<?php

require_once 'template.php';
require_once 'db.php';


$user_id = $_SESSION['ID'];
$user_result = mysql_query('SELECT * FROM users WHERE ID = "'. $user_id.'"');
$row = mysql_fetch_array($user_result);

$error = $_GET['err'];
$success = $_GET['success'];
$action = $_GET['action'];

$Template = new Template;
$avatar = $Template->GetUserAvatar();
$Template->PrintHeader($avatar);
if($action != "edit"){
    $Template->PrintProfile($row['id'],  $row['username'], $row['email'], $avatar, $row['gender'], $row['country'], $row['birthdate'], $error, $success);
}else{
    $Template->PrintProfileEdit($row['id'],  $row['username'], $row['email'], $avatar, $row['gender'], $row['country'], $row['birthdate'], $error, $success);
}
?>

</body>

</html>