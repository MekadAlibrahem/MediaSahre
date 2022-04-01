<?php

use MediaShare\Users\User;

include_once "../class.User.php" ;
try{
    $isdel = User::deleteBankAccount($_POST['account'] , $_POST['password']);
    if($isdel === true){
        echo  json_encode(array( "status" => true  ));
    }else{
        echo  json_encode(array( "status" => false  ,  "error" => $isdel));
    }
}catch(Exception $e){
    echo  json_encode(array( "status" => false  ,  "error" => $e->getMessage()));
}



?>