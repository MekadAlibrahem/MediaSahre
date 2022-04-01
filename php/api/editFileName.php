<?php 
    include_once "../class.File.php" ;
    use MediaShare\Files\File ;
    $isEdit = File::rename($_POST['fileeid'] , $_POST['newName'] ,$_POST['userid']);
    if($isEdit === true){
        echo json_encode(array('status' => true ));
    }else{
        echo json_encode(array('status'=> false , 'error'=>$isEdit));
    }



?>