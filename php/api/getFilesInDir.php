<?php 
include_once "../class.User.php";
use MediaShare\Files\File ;
try{
    $rootFileID = $_POST['foldeid'];
    $owner = $_POST['userid'];
    if($rootFileID == null){
        $rootFileID = File::getRootFileFromUser($owner);
        $rootFile = File::CreatObject($rootFileID);
    }else{
        $rootFile = File::CreatObject($rootFileID);
    }
    $list = File::getListFilesInformationInFolder($rootFile);

    $path = File::getPathFileAtArray($rootFile);
    echo json_encode(array("status" => true , "list" =>$list , "path"=>$path));

    
}catch(Exception $e){
    echo json_encode(array("status" => false , "error" =>$e->getMessage() ));

}



?>