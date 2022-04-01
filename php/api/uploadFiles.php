<?php 
include_once "../class.User.php" ;
use MediaShare\Files\File;
use MediaShare\ManagerDataBase;
use MediaShare\users\User ;



if ( 0 < $_FILES['file']['error'] ) {
    // echo json_encode(array( "msg"=> 'Error: ' . $_FILES['file']['error'] ));
    echo 'Error: ' . $_FILES['file']['error']  ;
}
else {
    try{
        $newFile = $_FILES['file']['name'] ;
        $file = File::CreatObject($_POST['filepath']);
        if(!$file instanceof File ) {
            //  echo json_encode(array( "status" => true , "msg" => "خطا لم يجد الملف الاب"  , "fileid"=> $_POST['filepath'])); 
             echo "خطا لم يجد الملف الاب"  ."fileid " .$_POST['filepath'] ;
        }else{
            $pathUserFolder = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ;
            $freespace = User::freeSpaceToUser($file->getOwner());
            if($freespace - $_FILES['file']['size'] < 0){
                // echo json_encode(array("status"=> true  ,'msg' => " لا تملك مساحة تخزين كافية"));
                echo " لا تملك مساحة تخزين كافية " ;
            }else if(!file_exists($pathUserFolder . '/' . $newFile)){
                move_uploaded_file($_FILES['file']['tmp_name'], $pathUserFolder . '/' . $newFile );
                $isInsert  = File::insertFolderInDataBase( $pathUserFolder . '/' . $newFile , $file->getFileID());
        
                $msg = "  تم إضافة الملف  " . $newFile   ;
                // echo json_encode(array( "status" => true , "msg" => $msg ));
                echo $msg ;
            }else{
                echo " إن هذا الملف موجود سابقا"  . $newFile ;
            }
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
    
   
}







?>