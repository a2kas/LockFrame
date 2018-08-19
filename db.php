<?php

//$host = "127.0.0.1:3307";             
//$username = "root";  
//$password = "adas123654"; 

$host = "127.0.0.1";             
$username = "adska_lockframe";  
$password = "04ppXR2PQeO&"; 
$database = "adska_lockframe";

$connection = mysql_connect($host, $username, $password);

if (!$connection)
  die('Could not connect: ' . mysql_error());
  
mysql_select_db("adska_lockframe",$connection) or die ("cannot select DB");



$DB_HOST 	 		= 'localhost';
$DB_NAME 	 		= 'adska_lockframe';
$DB_USERNAME 		= 'adska_lockframe';
$DB_PASSWORD 		= '04ppXR2PQeO&';
$SECURE_SALT_HASH 	= 'aNDNoOneWillEvarGuessit@)(!&#!(@*#&!#{';

try {
    $DB = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USERNAME, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die('DB error');
}

function pr($a){echo '<pre>'; print_r($a); echo '</pre>';}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// filter vars ffs..
function safe($data=''){
    if(gettype($data)=='array'){
        $new=array();
        foreach ($data as $value) 
            $new[]= trim(htmlspecialchars($value, ENT_QUOTES, 'utf-8'));
        return $new;
    }else 
        return trim(htmlspecialchars($data, ENT_QUOTES, 'utf-8'));
}
$_POST= array_map("safe", $_POST);
$_GET= array_map("safe", $_GET);


?>