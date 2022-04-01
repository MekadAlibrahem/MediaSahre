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


// $list = array(
//     [ 
//         "id"=> "1" ,
//         "name"=>"folder1" ,
//         "isFile"=> false ,
//         "type"=> "folder" ,
//         "size"=> "123.42 MB",
//         "link"=> "sdsdsdsa"
//     ],
   
// );
// $path = array( "count"=>2 , 
//     "list"=>array(
//         [
//             "name"  => "f1" ,
//             "id"    => "1"  ,
//             "end"   => false
//         ],
//     )
      
    

// );





?>