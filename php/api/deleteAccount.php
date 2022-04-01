<?php

use MediaShare\Users\User;

session_start();

include_once "../class.User.php" ;
try {
   $user = User::creatUser($_GET['id']);
   if($user instanceof User){
       $isDelete = $user->deleteAccount();
       if($isDelete === true ){
            session_destroy();
            echo  json_encode(array( "status" => true  , "href" => User::PUBLICPATH."/index.php" ));

       }else{
        echo  json_encode(array( "status" => false  , "error"  => $isDelete));

       }
   }else{
    echo  json_encode(array( "status" => false  , "error"  => $user));

   }
} catch (Exception $e) {
    echo  json_encode(array( "status" => false  , "error"  => $e->getMessage()));

}

?>