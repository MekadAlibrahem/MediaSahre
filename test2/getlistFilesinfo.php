<?php 
include "../php/class.File.php";
use MediaShare\Files\File ;
use MediaShare\ManagerDataBase;

$file = File::CreatObject(98);
$listFile = File::getListFilesInformationInFolder($file);
echo "<pre>" ;
print_r($listFile);
echo "</pre>"; 
// $list = array(
//     [ 
//         "id"=> "1" ,
//         "name"=>"folder1" ,
//         "isFile"=> false ,
//         "type"=> "folder" ,
//         "size"=> "123.42 MB",
//         "link"=> "sdsdsdsa"
//     ],
?>