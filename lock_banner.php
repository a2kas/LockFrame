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
<?php

require_once 'template.php';
require_once 'db.php';


$Template = new Template;
$avatar = $Template->GetUserAvatar();
$Template->PrintHeader($avatar);

?>
<style>
.contact {
color: #808080;
margin-top: 25%;
margin-left: 30%;
}

</style>
<script>
function submitThis() {
	//uploader.php?lockBanner&file='.$_GET['file'].'
	file = $('#file').val();
	locked = $('#locked').val();
	redirect_link = $('#redirect_link').val();
	$.ajax({
		dataType: 'json',
		url: 'uploader.php?lockBanner&file=' + file,
		type: 'POST',
		data: { locked : locked, redirect_link: redirect_link},
		success: function (data, status, xhr) {
			if(data.err) {
				if(data.err == 'Banner with same code') {
					$('.eerr').html('This banner already exist');
				}

				if(data.err == 'bad link') {
					$('.eerr').html('Bad redirect link typed.');
				}
				if(data.err == 'k') {
					document.location = "/links.php";
				}
			}
		}
	});
}

</script>
<div class="contact">
<?php
if($_GET['pg'] == "bannerlock") {
$baneris = $_GET['banner_url'];
$ur = base64_decode($_GET['url']);
//echo $ur;

$failas = $_GET['file'];
echo '
<h2>Banner Lock</h2>
            <p><b>Your link:</b>&nbsp;<div class="locking_link">'.$ur.'</div></p>
            <p>
            	Your uploaded banner: <br/>
				<img src="http://lockframe.net/uploads/'.$failas.'" size="50%">
			</p>
             <div id="lock_error">'.$_GET['erroriukas'].'</div>
            <form method="post" action="#">
				<p><label>Banner link:</label>&nbsp;<input type="text" id="redirect_link" name="redirect_link"></p>
                <input type="text" name="locked" id="locked" value="'.$ur.'" style="display: none;"/>
                <input type="text" name="locked" id="file" value="'.$_GET['file'].'" style="display: none;"/>
				<button type="submit" name="submit" onclick="submitThis(); return false;">Lock</button>
            </form>
            <p style="color: #FF5E5E; font-weight: bolder;" class="eerr"></p>



';

 }
?>


</div>

