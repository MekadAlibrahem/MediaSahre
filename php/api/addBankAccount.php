<?php

use MediaShare\Users\User;

include_once "../class.User.php" ;
try{
    $isadd = User::insertNewBankAccount($_POST['account'] , $_POST['password'] , $_POST['count']);
    if($isadd === true){
        echo  json_encode(array( "status" => true  ));
    }else{
        echo  json_encode(array( "status" => false  ,  "error" => $isadd));
    }
    
}catch(Exception $e){
    echo  json_encode(array( "status" => false  ,  "error" => $e->getMessage()));
}



?>