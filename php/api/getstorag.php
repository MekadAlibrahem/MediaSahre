<?php

use MediaShare\Users\User;

include_once "../class.User.php" ;

$user = User::creatUser($_POST['id']);
if($user instanceof User){
   $size =  User::getSpaseUsed($user->getUserID()) ;
   $freeMemory = User::freeSpaceToUser($user->getUserID());

   echo  json_encode(array( "status" => true  ,  "size" => $size['size'] , "total" => $size['totalsize']  , "formatSize" => $size['formatSize'] , 'freeMemory' => $freeMemory));
}else{
    echo  json_encode(array( "status" => false  ,  "error" => $user));
}

?>