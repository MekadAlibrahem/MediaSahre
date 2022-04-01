<?php

use MediaShare\Files\File;
use MediaShare\ManagerDataBase;
use MediaShare\Users\User ;
include_once "../class.User.php" ;
include_once "../class.Archive.php" ;

if(isset($_FILES)){
    $freespace = User::freeSpaceToUser($file->getOwner());
    if($freespace - $_FILES['file']['size'] < 0){
        echo json_encode( array('status' => " لا تملك مساحة تخزين كافية  "));

    }
    $file = File::CreatObject($_POST['pathFile']);
    $rootFolderName = $_POST['foldername'];
    $pathUserFolder = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ;
    if(file_exists($pathUserFolder . '/' . $rootFolderName)){
        echo json_encode( array('status' => "إن هذا المجلد موجود سابقا ، يجب إعادة تسمية المجلد اولا "));
    }else{
        foreach ($_FILES as $key => $value) {
            $fileNameTemp   = time().$rootFolderName ;
            $pathSaveTempZipFile = ManagerDataBase::TEMPFOLDER . $fileNameTemp ;
            move_uploaded_file($_FILES[$key]['tmp_name'], $pathSaveTempZipFile);
            Archive::unzip($pathSaveTempZipFile , $pathUserFolder);
            $isInsert  = File::insertFolderInDataBase($pathUserFolder ."/".$rootFolderName , $_POST['pathFile']);
            echo json_encode( array('status' => "تم رفع جميع الملفات "));
            unlink($pathSaveTempZipFile);
        }
    }
    
}





?>