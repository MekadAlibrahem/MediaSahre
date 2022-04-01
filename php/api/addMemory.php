<?php 
session_start();
include_once "../class.User.php" ;
use MediaShare\Users\User ;
try{
    $isAdd = User::payMemory($_POST["id"] , $_POST['account'] , $_POST['password'] , $_POST["count"]);
    if($isAdd === true){
        echo  json_encode(array( "status" => true   ));

    }else{
        echo  json_encode(array( "status" => false , "error"=>$isAdd->getMessage()   ));

    }

}catch(Exception $e){
    echo  json_encode(array( "status" => false  , "error" => $e->getMessage()   ));

}


  


?>