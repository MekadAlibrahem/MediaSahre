<?php

use MediaShare\Users\User;

include_once "../class.User.php" ;
try{
    $list = User::getAllBankAccount();
    if(is_array($list) ){
        echo  json_encode(array( "status" => true  , 'list'=> $list ));
    }else{
        echo  json_encode(array( "status" => false  ,  "error" => $list));
    }
}catch(Exception $e){
    echo  json_encode(array( "status" => false  ,  "error" => $e->getMessage()));
}



?>