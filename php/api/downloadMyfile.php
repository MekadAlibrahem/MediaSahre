<?php 
include_once "../class.File.php" ;
include_once "../class.Archive.php" ;
use MediaShare\Files\File ;

use MediaShare\ManagerDataBase;

$isValid = File::checkValidDownload($_POST['fileid'] , $_POST['userid']);
if($isValid === true){
    $file = File::CreatObject($_POST['fileid']);
    if($file instanceof File){
        $sourseFile = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ;
        if(is_file($sourseFile)){
            $filezipName =  time() . $file->getFileName();

            $dest =  ManagerDataBase::FOLDERDOWNLOAD . time(). '_' . $file->getFileName() ;
            copy($sourseFile , $dest );
            echo json_encode(array('status'=> true , "f"=>$filezipName ));

        }else{
            $filezipName =  time() . $file->getFileName() . '.zip';
        $dest = ManagerDataBase::FOLDERDOWNLOAD. $filezipName  ;
        // echo $dest;
        Archive::zip($sourseFile , $dest);
        echo json_encode(array('status'=> true , "f"=>$filezipName ));
        }
       
       
    }else{
        echo json_encode(array('status'=>false , 'error'=> $file));
    }
}else{
    echo json_encode(array('status'=>false , 'error'=> $isValid));
}





?>