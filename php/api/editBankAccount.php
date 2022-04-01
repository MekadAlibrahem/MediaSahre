<?php

use MediaShare\Users\User;

include_once "../class.User.php" ;
try{
    $isEdit = User::updateCountToBacnkAccount($_POST['account'] , $_POST['password'] , $_POST['count']);
    if($isEdit === true){
        echo  json_encode(array( "status" => true  ));
    }else{
        echo  json_encode(array( "status" => false  ,  "error" => $isEdit));
    }
    
}catch(Exception $e){
    echo  json_encode(array( "status" => false  ,  "error" => $e->getMessage()));
}



?>