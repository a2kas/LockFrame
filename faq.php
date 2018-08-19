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
$Template->PrintFAQ();
?>

</body>

</html>