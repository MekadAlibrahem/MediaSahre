<?php 
session_start();
include_once "../class.User.php" ;
use MediaShare\Users\User ;

$user  = User::creatUser($_POST['id']);
if($user instanceof User){
    $isedit = $user->editEmail($_POST['email']);
    if($isedit === true){
        $_SESSION['email'] = $_POST['email']; 
        echo  json_encode(array( "status" => true  ));

    }else{
        echo  json_encode(array( "status" => false  ,  "error" => "لم يتم تعديل البريد الالكتروني :  ".$isedit));
    }
}else{
    echo  json_encode(array( "status" => false  ,  "error" => $user));
}


?>