<?php 
include_once "../class.Admin.php" ;
use MediaShare\Users\Admin ;

try{
    $list  = Admin::getAllUser();
    if($list){
        echo json_encode(array("status" => true ,  "list" => $list));
    }else{
        echo json_encode(array("status" => false ,  "error" => $list  ));
    }
    
}catch(Exception $e){
    echo json_encode(array("status" => false ,  "error" => $e->getMessage()  ));
}


?>