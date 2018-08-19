<?php
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

  include('db.php');
  
if (isset($_POST['update'])) {
	// UPDATE COMMAND 
  if(empty($_POST['password'])) {
    die(json_encode(array('err'=>'empty pass')));
  } 

  if(empty($_POST['link']))
     die(json_encode(array('err'=>'empty link')));
    
    $kdl = 0;
    if(preg_match('/https\:\/\//', $_POST['link'])) {
        $kdl = 1;
    }else if(preg_match('/http\:\/\//', $_POST['link'])) {
        $kdl = 2;
    } 

    if($kdl == 0)
        die(json_encode(array('err' => 'bad link')));

	if(strlen($_POST['password']) < 4)
		die(json_encode(array('err'=>'too short')));

	$update_query = "UPDATE links_password SET link ='".mysql_real_escape_string($_POST['link'])."', password ='".mysql_real_escape_string($_POST['password'])."' WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($update_query);
    echo $result;
}
else if (isset($_POST['delete'])){
    $delete_query = "DELETE FROM links_password WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($delete_query);
    $delete_query = "DELETE FROM password_links_unlock WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($delete_query);
    echo $result;
}
else
{
  // get data and store in a json array
  $query = "SELECT * FROM links_password WHERE owner_id = ".$_SESSION['ID']."";

  $result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	    $links[] = array(
			'Code' => "lockframe.net/pp".$row['code'],
			'Link' => $row['link'],
			'Date' => $row['date'],
			'Password' => $row['password']
		);
  }

  echo json_encode($links);
}
?>