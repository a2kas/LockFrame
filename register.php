<?php 
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}


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
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<?php

require_once 'template.php';
$Template = new Template;
$avatar = $Template->GetUserAvatar();
$Template->PrintHeader($avatar);
if(!isset($_SESSION['ID']))
	$Template->PrintRegisterForm();
else
{
	?><script type="text/javascript">
	<!--
	window.location = "profile";
	//-->
	</script>
	<?php
}
?>
</body>

</html>