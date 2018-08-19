<?php 
require_once 'db.php';
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

$target_path = "banners/";

        // if(isset($_POST['redirect_link'])$_POST['redirect_link'] == ""){
       //         $notice = 'Please provide banner redirect link!';
       //         header("Location: lock.php?type=banner&notice=".$error."");
       //   }

// Kintamieji
$target_path = $target_path . basename( $_FILES['file']['name']); 
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$name = $_FILES['file']['name'];
$user_id = $_SESSION['ID'];
$typeprefix = '';
$bad_format = 0;


// Nustatome koks yra failo tipas
if ($type == 'image/jpeg') {
   $typeprefix = '.jpeg';
} else if ($type == 'image/gif'){
   $typeprefix = '.gif';
} else if ($type == 'image/png'){
   $typeprefix = '.png';
} else if($type == NULL){
    $error = 'File is not chosen!';
    header("Location: lock.php?type=banner&notice=".$error."");
    $bad_format = 1;
} else {
    $error = 'Bad avatar format! Must be .gif, .png or .jpeg format!';
    header("Location: lock.php?type=banner&notice=".$error."");
    $bad_format = 1;
}

// Jeigu blogas formatas, praleidžiame talpinimą!
if($bad_format == 0){
    
	$image_info = getimagesize($_FILES['file']['tmp_name']);
    $image_width = $image_info[0];
    $image_height = $image_info[1];
	
    // Tikriname ar teisingi avataro išmatavimai
    if($image_width > 800 || $image_height > 400){
        $error = 'Bad banner dimensions! Must be no bigger than 800x400 pixels.';
		header("Location: lock.php?type=banner&notice=".$error."");
	} else if ($size > 100000){
	    $error = 'Banner size is too high! Max size 100KB!';
		header("Location: lock.php?type=banner&notice=".$error."");
    } else {

         if($_POST['redirect_link'] == ""){
                $notice = 'Please provide banner redirect link!';
                header("Location: lock.php?type=banner&notice=".$notice."");
                exit;
          }
        // Vykdome avataro talpinimą
        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {

                $notice = 'Banner successfully uploaded!';
                $duplicate = true;
                $code = "";
                // That ensure as will not be entries with same code!
                while($duplicate){
                     $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7); 
                     $result = mysql_query('SELECT * FROM links_banner WHERE code = "'.$code.'"');
                     $count = mysql_num_rows($result);
                     if($count < 1 ){
                            $duplicate = false;
                        }
                      }
                $new_name = $code.$typeprefix;

                rename ("banners/$name", "banners/$new_name");
                mysql_query('INSERT INTO links_banner (code, link, banner, redirect_link, owner_id, waittime, date) VALUES ("'.$code .'","'.$_POST['locked_link'].'","'. $new_name .'","'.$_POST['redirect_link'].'",'.$user_id.','.$_POST['wait_time'].', NOW())');
                header("Location: links.php");
        
        } else {
		        $error = 'There was an error uploading the file, please try again!';
                header("Location: lock.php?type=banner&notice=".$error."");
        }

		// Išrenkame dabartinį vartotojo avatarą
   //     $result = mysql_query("SELECT avatar FROM users WHERE ID = '".$user_id."'");
	//    $row = mysql_fetch_array($result);

    	// Suformuojame avataro pavadinima pagal vartotojo ID ir failo tipą
     //   $new_name = $user_id.$typeprefix;
	    // Pervadiname patalpintą failą
	 //   if($name != 'no_avatar_90x90.gif')
     //       rename ("avatars/$name", "avatars/$new_name");
	
	    // Įrašome į duomenų bazę naują avataro pavadinimą
	   // mysql_query("UPDATE users SET avatar = '".$new_name."' WHERE ID = '".$user_id."'");
        
        
    }
    
}





?>
