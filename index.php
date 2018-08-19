<?php 
//define('INCLUDED', true);
//define('ROOT_PATH', 'forum/');
//include 'forum/sources/common.php';
//$session->update('index');
//if(isset($session->sess_info['user_info'])) {
 //   $_SESSION['ID'] = $session->sess_info['user_info']['id'];
 //   $_SESSION['username'] = $session->sess_info['user_info']['name'];
//}



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
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
var uid = '117797';
var wid = '269247';
</script>
<script type="text/javascript" src="//cdn.popcash.net/pop.js"></script>
</head>
<body>
<?php

require_once 'template.php';
$Template = new Template;
$avatar = null;//$Template->GetUserAvatar();
$Template->PrintHeader($avatar);
?>
<form id="lock_form">
<table>
<tr>
<td colspan="4">Insert link which you want to lock and select lock type<div id="lock_error"></div></td>
</tr>
<tr>
<td colspan="4"><input type="text" id="link_input" name="link_input" maxlength="250"></td>
</tr>
<tr>
<td><input type="radio" id="banner_radio" name="type" value="banner">Banner</td>
<td><input type="radio" id="social_radio" name="type" value="social" checked>Social</td>
<td><input type="radio" id="password_radio" name="type" value="password">Password</td>
<td><button id="lock_submit" type="submit">Lock it</button></td>
</tr>
</table>
</form>

<div id="ads" style="margin-top: 25px; margin-left: 6%;">
	<iframe data-aa='401669' src='//ad.a-ads.com/401669?size=728x90' scrolling='no' style='width:728px; height:90px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
</div>
<div id="footer" style="margin-top: 10px; margin-left: 25px; color: grey;">2016 - 2017 &copy; Lockframe.net. All rights reserved.</div>
</body>
</html>