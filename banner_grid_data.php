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
  $banner = '';
  if(isset($_SESSION['newBanner'])) {
    $banner = ", banner='".$_SESSION['newBanner']."'";
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

 if(empty($_POST['link2']))
     die(json_encode(array('err'=>'empty link2')));
    
    $kdl = 0;
    if(preg_match('/https\:\/\//', $_POST['link2'])) {
        $kdl = 1;
    }else if(preg_match('/http\:\/\//', $_POST['link2'])) {
        $kdl = 2;
    } 
    if($kdl == 0)
        die(json_encode(array('err' => 'bad link2'))); 



  
	$update_query = "UPDATE links_banner SET link ='".mysql_real_escape_string($_POST['link'])."', redirect_link='".mysql_real_escape_string($_POST['link2'])."' ".(!empty($banner)?$banner : '')." WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
  unset($_SESSION['newBanner']);
  //echo $update_query;
    $result = mysql_query($update_query);
    echo $result;
}
else if (isset($_POST['delete'])){
    $delete_query = "DELETE FROM links_banner WHERE `code`='".mysql_real_escape_string($_POST['code'])."'";
    $result = mysql_query($delete_query);
    echo $result;
}
else
{
  // get data and store in a json array
  $query = "SELECT * FROM links_banner WHERE owner_id = ".$_SESSION['ID']."";

  $result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	    $links[] = array(
			'Code' => "lockframe.net/bb".$row['code'],
			'Link' => $row['link'],
			'Date' => $row['date'],
      'Banner' => '<img src="http://lockframe.net/uploads/'.$row['banner'].'" style="width: 50px;">',
      'BannerLink' => $row['redirect_link']
		);
  }

  echo json_encode($links);
}
?>