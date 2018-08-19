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

$target_path = "avatars/";

// Kintamieji
$target_path = $target_path . basename( $_FILES['file']['name']); 
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$user_id = $_SESSION['ID'];
$name = $_FILES['file']['name'];
$typeprefix = '';
$bad_format = 0;


if($name == 'no_avatar_90x90.gif'){
    $error = 'Avatar name is incorrect! Rename it!';
    header("Location: profile.php?err=$error&success=".NULL."&action=".NULL."");
    
} else {
    // Nustatome koks yra failo tipas
if ($type == 'image/jpeg') {
   $typeprefix = '.jpeg';
} else if ($type == 'image/gif'){
   $typeprefix = '.gif';
} else if ($type == 'image/png'){
   $typeprefix = '.png';
} else if($type == NULL){
    $error = 'File is not chosen!';
    header("Location: profile.php?err=$error&success=".NULL."&action=".NULL."");
    $bad_format = 1;
} else {
    $error = 'Bad avatar format! Must be .gif, .png or .jpeg format!';
    header("Location: profile.php?err=$error&success=".NULL."&action=".NULL."");
    $bad_format = 1;
}

// Jeigu blogas formatas, praleidžiame talpinimą!
if($bad_format == 0){
    
	$image_info = getimagesize($_FILES['file']['tmp_name']);
    $image_width = $image_info[0];
    $image_height = $image_info[1];
	
    // Tikriname ar teisingi avataro išmatavimai
    if($image_width != 90 || $image_height != 90){
        $error = 'Bad avatar dimensions! Must be 90x90 pixels.';
		header("Location: profile.php?err=".$error."&success=".NULL."&action=".NULL."");
	} else if ($size > 50000){
	    $error = 'Avatar size is too high! Max size 50KB!';
		header("Location: profile.php?err=".$error."&success=".NULL."&action=".NULL."");
    } else {
        
        // Vykdome avataro talpinimą
        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                $success = 'Avatar successfully uploaded! If avatar does not changed, refresh page.';
                header("Location: profile.php?err=".NULL."&success=".$success."&action=".NULL."");
        } else {
		        $error = 'There was an error uploading the file, please try again!';
                header("Location: profile.php?err=".$error."&success=".NULL."&action=".NULL."");
        }
	    
		// Išrenkame dabartinį vartotojo avatarą
        $result = mysql_query("SELECT avatar FROM users WHERE ID = '".$user_id."'");
	    $row = mysql_fetch_array($result);

    	// Suformuojame avataro pavadinima pagal vartotojo ID ir failo tipą
        $new_name = $user_id.$typeprefix;
	    // Pervadiname patalpintą failą
	    if($name != 'no_avatar_90x90.gif')
            rename ("avatars/$name", "avatars/$new_name");
	
	    // Įrašome į duomenų bazę naują avataro pavadinimą
	    mysql_query("UPDATE users SET avatar = '".$new_name."' WHERE ID = '".$user_id."'");
        mysql_query("UPDATE usebb_members SET avatar_type = 1,avatar_remote = 'http://lockframe.net/avatars/".$new_name."' WHERE id = '".$user_id."'");
        
    }
    
}



}

?>