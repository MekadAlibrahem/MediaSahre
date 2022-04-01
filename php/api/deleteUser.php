<?php

use MediaShare\Users\User;



include_once "../class.User.php" ;
try {
   $user = User::creatUser($_GET['id']);
   if($user instanceof User){
       $isDelete = $user->deleteAccount();
       if($isDelete === true ){
            echo  json_encode(array( "status" => true  ));

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