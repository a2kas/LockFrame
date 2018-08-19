<?php define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

if(isset($_GET['ajax'])) {

require('uploader/Uploader.php');

// Directory where we're storing uploaded images
// Remember to set correct permissions or it won't work
$upload_dir = 'uploads/';
$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7);
$png= '.png';
$target_file =  basename($random, $png);

$uploader = new FileUpload('imgfile');
$uploader->newFileName = $target_file.$png;
// Handle the upload
$result = $uploader->handleUpload($upload_dir);

if (!$result) {
  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
}

echo json_encode(array('success' => true, 'file' => $target_file.$png));

    $_SESSION['newBanner'] = $target_file.$png;
    die();
}


$ur = $_GET['url'];
include "config.php";


if(isset($_GET['lockBanner']) & isset($_POST['redirect_link']) & isset($_POST['locked']) & isset($_GET['file'])) {
    include 'db.php';
    include 'template.php';

    $code = explode('.', $_GET['file']);

    $banner = $DB->query("SELECT * FROM links_banner WHERE code='".$code[0]."' LIMIT 1")->fetch();
    $kdl = 0;
    if(preg_match('/https\:\/\//', $_POST['redirect_link'])) {
        $kdl = 1;
    }else if(preg_match('/http\:\/\//', $_POST['redirect_link'])) {
        $kdl = 2;
    } 

    if($kdl == 0)
        die(json_encode(array('err' => 'bad link')));
    

    if(empty($banner)) {
        $newBanner = $DB->prepare("INSERT INTO links_banner SET code=:code, banner=:banner, link=:link, redirect_link=:link2, owner_id=:owner, date=:date");
        $newBanner->bindParam(':code', $code[0], PDO::PARAM_STR, 20);
        $newBanner->bindParam(':banner', $_GET['file'], PDO::PARAM_STR, 20);
        $newBanner->bindParam(':link', $_POST['redirect_link'], PDO::PARAM_STR);
        $newBanner->bindParam(':link2', $_POST['locked'], PDO::PARAM_STR);
        $newBanner->bindParam(':owner', $_SESSION['ID'], PDO::PARAM_INT, 10);
        $date = date("Y-m-d H:i:s");
        $newBanner->bindParam(':date', $date, PDO::PARAM_STR, 100);
        $newBanner->execute();
        die(json_encode(array('err' => 'k')));
    } else {
        die(json_encode(array('err' => 'Banner with same code')));
    }
  

}




$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7);
$target_dir = "uploads/";
$png= '.png';
$target_file = $target_dir . basename($random, $png);
$uploadOk = 1;
echo $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["imgfile"]["tmp_name"]);
    if($check !== false) {
       // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        die(json_encode(array('err' => 'File is not an image')));
        $uploadOk = 0;
    }
}
$imageFileType = $_FILES["imgfile"]["type"];

// Check file size
if ($_FILES["imgfile"]["size"] > 500000) {
    $toolarge = "Sorry, your file is too large.";
    die(json_encode(array('err' => $toolarge)));
    $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "image/jpg" && $imageFileType != "image/png" && $imageFileType != "image/jpeg"
&& $imageFileType != "image/gif" ) {
     die(json_encode(array('err' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.')));
    $uploadOk = 0;
}
//$image_info = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $check = getimagesize($_FILES["imgfile"]["tmp_name"]);
    $image_width = $check[0];
    $image_height = $check[1];
    // Tikriname ar teisingi avataro išmatavimai
    if($image_width > 800 || $image_height > 300){
  
        $error = 'Bad banner dimensions! Must be no bigger than 800x300 pixels.';
        die(json_encode(array('err' => $error)));
        $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    // if everything is ok, try to upload file

    } else {
        $tipas = '.png';
        $failiukas = $random . $tipas;
        $target_file1 = $target_file . $tipas;
            if (move_uploaded_file($_FILES["imgfile"]["tmp_name"], $target_file1)) {
        die(json_encode(array('err' => '1', 'file'=>$failiukas)));
    } else {
        
    $klaidike = "Sorry, there was an error uploading your file.";
     die(json_encode(array('err' => $klaidike)));

    }
}


?>