<?php
    
require_once '../db.php';
$code = $_POST['code'];$ip = $_POST['ip'];

if(!empty($code) ){    mysql_query("INSERT INTO banner_links_unlock VALUES('".$code."','".$ip."')");
    exit(json_encode('done'));
}

?>