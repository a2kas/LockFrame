<?php


if(isset($_POST['facebook'])){
    $fb_checkbox = 1;
}else{
    $fb_checkbox = 0;
    
}
if(isset($_POST['twitter'])){
    $tw_checkbox = 1;
}else{
    $tw_checkbox = 0;
}
if(isset($_POST['google'])){
    $g_checkbox = 1;
}else{
    $g_checkbox = 0;
}
if(isset($_POST['title'])) {
    $title = $_POST['title'];
} else $title = '';

if(isset($_POST['description'])) {
    $description = $_POST['description'];
} else $description = '';

$array = array('fb' => $fb_checkbox , 'tw' => $tw_checkbox , 'g' => $g_checkbox, 'title' => $title, 'description' => $description);

 echo json_encode($array); 



?>