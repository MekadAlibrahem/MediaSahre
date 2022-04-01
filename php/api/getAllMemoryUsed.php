<?php 
include_once "../class.Admin.php" ;
use MediaShare\Users\Admin ;

try{
    $count  = Admin::getAllMemoryUsed();
    if($count){
        echo json_encode(array("status" => true ,  "count" => $count));
    }else{
        echo json_encode(array("status" => false ,  "error" => $count  ));
    }
    
}catch(Exception $e){
    echo json_encode(array("status" => false ,  "error" => $e->getMessage()  ));
}


?>