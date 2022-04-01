<?php 
    include_once "../class.File.php" ;
    use MediaShare\Files\File ;

    $isEdit = File::deleteView($_POST['fileid'] , $_POST['viewId'] ,$_POST['userid']);
    if($isEdit === true){
        echo json_encode(array('status' => true ));
    }else{
        echo json_encode(array('status'=> false , 'error'=>$isEdit));
    }



?>