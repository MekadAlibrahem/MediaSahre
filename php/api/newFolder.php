<?php 
include_once "../class.File.php" ;
use MediaShare\Files\File ;
try{
        // 'parent' : parentID , 'folderName' : folderName ,'type':type , 'userid' : userid
    $isDone =  File::newFolder($_POST['folderName'] , $_POST['userid'] , $_POST['type'] , $_POST['parent']);
    if($isDone === true){
        echo json_encode(array('status' => true ));
    }else{
        echo json_encode(array('status' => false , 'error' => $isDone ));
    }
}catch(Exception $e){
    echo json_encode(array('status' => false  , 'error' => $e->getMessage()));

}

?>