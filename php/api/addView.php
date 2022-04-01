<?php
include_once "../class.User.php" ;
use MediaShare\Files\File ;
use MediaShare\Users\User ;
// data:{'fileeid': fileid , 'viewEmail' : viewEmail , 'userid' : userid},
try{
    $viewID = User::getUserIdByUserName($_POST['viewName']);
    $isEdit = File::addView($_POST['fileeid'] , $viewID ,$_POST['userid']);
    if($isEdit === true){
        echo json_encode(array('status' => true ));
    }else{
        echo json_encode(array('status'=> false , 'error'=>$isEdit));
    }
}catch(Exception $e){
    echo json_encode(array('status'=> false , 'error'=>$e->getMessage()));

}

?>