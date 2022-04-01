<?php
include_once "../class.File.php" ;
include_once "../class.Archive.php" ;


use MediaShare\Files\File ;
use MediaShare\ManagerDataBase;

function rcopy($src, $dst) {
    
    if(is_file($src)) {
        copy($src , $dst);
     }else {
      mkdir($dst);
      $files = scandir($src);
      foreach ($files as $file)
        if ($file != "." && $file != "..") {
           
            rcopy("$src/$file", "$dst/$file");
        }
    } 
  }
  

try {
    $Namefolder = time() ."_archive"  ;
    $PathTempFolder = ManagerDataBase::TEMPFOLDER . $Namefolder ;
    if(mkdir($PathTempFolder)  === true){
        $result  = "" ;
        foreach ($_GET['l'] as  $sourceFile) {
            $file = File::CreatObject($sourceFile);
            $sourceFilePath = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ;
            $dest =  $PathTempFolder ."/" .  $file->getFileName() ;
           
            // $spl =  new SplFileInfo($sourceFilePath);
                rcopy($sourceFilePath , $dest);
           
        }
    
        $temp_zip_name = $Namefolder . ".zip" ;
        $temp_zip_file = ManagerDataBase::TEMPFOLDER . $temp_zip_name ; 
        $isZip = Archive::zip($PathTempFolder , $temp_zip_file);
        if($isZip === true ){
            $user_folder = File::CreatObject($_GET['f']);
    
            $user_path_file = ManagerDataBase::ROOTPATH . $user_folder->getPath() . $user_folder->getFileName()   ;
            $isCopy = copy($temp_zip_file , "$user_path_file/$temp_zip_name" );
            // $isCopy = File::xcopy($temp_zip_file , $user_path_file);
            $isInsert = File::insertFolderInDataBase("$user_path_file/$temp_zip_name" , $user_folder->getFileID());
            $delete = File::deleteContent($PathTempFolder);
            rmdir($PathTempFolder);
            unlink($temp_zip_file);
            echo json_encode(array("status" => true  , "result" => $result   ));
        }else{
            echo json_encode(array("status" => false  , 'error' => "error"   ));
        }
    }else{
        echo json_encode(array("status" => false  , 'error' => "mkdir temp folder " , 'p' => $PathTempFolder));
    }

    

   


   
} catch (Exception $e) {
    echo json_encode(array("status" => false , "error" => $e->getMessage() ));
}

?>