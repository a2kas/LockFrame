<?php

require_once 'db.php';
$id = $_GET["id"];
mysql_query("DELETE FROM logins WHERE id = '".$id."'");
mysql_query("DELETE FROM votes WHERE id = '".$id."'");
header('Location: admin.php');
?>