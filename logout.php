<?php
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
foreach($_SESSION AS $key=>$SES) {
    unset($_SESSION[$key]);
}


$session->update('logout');
$functions->unset_al();
$session->destroy();
header('Location: home');

?>