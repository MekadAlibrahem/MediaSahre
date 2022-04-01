<?php

use MediaShare\Files\FMDB;

include_once "../class.File.php" ;
use MediaShare\Files\File ;

$list = File::getListOfTypeFile();
try{
    if(is_array($list)){
         echo json_encode(array( 'status' => true , 'list'=> $list ));
       }else{
         echo json_encode(array('status'=> false , 'error'=>$list));
       }
}catch(Exception $e){
    echo json_encode(array('status'=> false , 'erroe'=> $e->getMessage()));

}


?>