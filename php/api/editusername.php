<?php 
session_start();
include_once "../class.User.php" ;
use MediaShare\Users\User ;

$user  = User::creatUser($_POST['id']);
if($user instanceof User){
    $isedit = $user->editUserName($_POST['name']);
    if($isedit === true){
        $_SESSION['username'] = $_POST['name']; 
        echo  json_encode(array( "status" => true  ));

    }else{
        echo  json_encode(array( "status" => false  ,  "error" => ":لم يتم تعديل الاسم  ".$isedit));
    }
}else{
    echo  json_encode(array( "status" => false  ,  "error" => $user));
}


?>