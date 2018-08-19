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

   if($_POST['fb_check'] == 0 & $_POST['tw_check'] == 0 & $_POST['g_check'] == 0) {
   		die(json_encode(array('err' => 'no act'))); 
   }
   $titleLength = strlen($_POST['Title']);
   if($titleLength < 5 || $titleLength > 50)
      die(json_encode(array('err' => 'titleLength'))); 

   $descriptionLen = strlen($_POST['Description']);
   if($descriptionLen < 10 || $descriptionLen > 250)
      die(json_encode(array('err' => 'descriptionLen'))); 
  
	$linkLength = strlen($_POST['link']);
	if(250 < $linkLength)
		die(json_encode(array('err' => 'linkLen')));
		
	$update_query = "UPDATE links_social SET description='".$_POST['Description']."', title='".$_POST['Title']."', link ='".mysql_real_escape_string($_POST['link'])."', facebook =".$_POST['fb_check'].", twitter =".$_POST['tw_check'].", google =".$_POST['g_check']." WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($update_query);
    echo $result;
}
else if (isset($_POST['delete'])){
    $delete_query = "DELETE FROM links_social WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($delete_query);
    $delete_query = "DELETE FROM social_links_unlock WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($delete_query);
    echo $result;
}
else
{
  // get data and store in a json array
  $query = "SELECT * FROM links_social WHERE owner_id = ".$_SESSION['ID']."";

  $result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
  if($row['facebook'] == 1){
       $fb = true;
  }
  else{
      $fb = false;
  }

  if($row['twitter'] == 1){
       $tw = true;
  }
  else{
      $tw = false;
  }

  if($row['google'] == 1){
      $g = true;
  }
  else{
      $g = false;
  }
  $links[] = array(
        'Code' => "lockframe.net/ss".$row['code'],
        'Link' => $row['link'],
		'Date' => $row['date'],
		'Facebook' => $fb,
		'Twitter' => $tw,
		'Google' => $g,
    'Title' => $row['title'],
    'Description' => $row['description']
      );
  }

  echo json_encode($links);
}
?>