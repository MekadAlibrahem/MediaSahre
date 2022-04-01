<?php 

include_once "../class.File.php"; 
include_once "../class.Archive.php";

use MediaShare\Files\File ;
// use Archive ;
use MediaShare\ManagerDataBase;

$listFile = array() ;
foreach ($_GET['l'] as  $id) {
    $file  = File::CreatObject($id);
    $path = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ; 
    array_push($listFile , $file) ;
    $fileName = $file->getFileName() ;
    $fileSpl = new SplFileInfo($path);
    if($fileSpl->getExtension() !== 'zip'){
        echo json_encode(array("status" => false  , 'error' => "إن الملف $fileName  ليس ملف مضغوط "   ));
        return ;
    }
}
$dest_folder  = File::CreatObject($_GET['f']);
$dest_path = ManagerDataBase::ROOTPATH  .$dest_folder->getPath() . $dest_folder->getFileName() ;
foreach ($listFile as  $file) {
    $zip_path = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ; 
    $path_parts = pathinfo($zip_path);
    $fileNameWithOutExtension =  $path_parts['filename'] ;
    $unzip = Archive::unzip($zip_path , "$dest_path/");
    $isInsert  = File::insertFolderInDataBase("$dest_path/$fileNameWithOutExtension" , $dest_folder->getFileID());
}

echo json_encode(array("status" => true   ));



?>