<?php 
include_once "../class.File.php" ;
use MediaShare\Files\File ;

$isdelete  = File::delete($_POST['fileid']);
if($isdelete === true){
    echo json_encode(array('status'=> true ));
}else{
    echo json_encode(array('status'=> false , 'error' => $isdelete ));
}



?>