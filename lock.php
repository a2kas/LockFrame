<?php define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
//$session->update('index');
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
<link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
<title>LockFrame - Online Affiliate Tool</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="js/javascripts.js"></script>
<script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="jqwidgets/jqxtooltip.js"></script>
<script type="text/javascript" src="scripts/gettheme.js"></script>

<script type="text/javascript" src="js/SimpleAjaxUploader.js"></script>

 <script type="text/javascript">
        $(document).ready(function () {
            var theme = getDemoTheme();
            $("#redirect_link").jqxTooltip({ content: 'A link to the user will be redirect after click on your banner', position: 'mouse', autoHide: false, theme: theme });
            $("#wait_time").jqxTooltip({ content: 'It`s time in seconds which visitor must wait as he can click on your advertisiment.</br> Default value is 0 seconds.</br> <b>Max value can be 999</b>', position: 'mouse', autoHide: false, theme: theme });

        });
</script>
</head>

<body>
<style>

.lockban {
color: black;
position: absolute;
margin-top: 12%;
font-size: 14pt;
}

</style>
<?php

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

require_once 'template.php';
$Template = new Template;
$avatar = $Template->GetUserAvatar();
$Template->PrintHeader($avatar);
$URL = $_SESSION['lock_link'];
$lock_type = $_GET['type'];

switch ($lock_type) {
case "banner":
       // Paiimame sugeneruotą kodą po to kai banneris yra uploadintas

         if(isset($_GET['notice'])){
             $notice = $_GET['notice'];
         }else{
             $notice = "";
         }
         $Template->PrintBannerLock($URL, $notice);
    break;
case "social":
        $Template->PrintSocialLock($URL);
    
    
    
    break;
case "password":
		$Template->PrintPasswordLock($URL);
    
    
    
    

    break;
}



?></body>

</html>
