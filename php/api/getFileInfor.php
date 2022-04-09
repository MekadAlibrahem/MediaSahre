<?php

use MediaShare\Files\File;
use MediaShare\ManagerDataBase;

include_once "../class.File.php" ;

$file = File::CreatObject($_POST['fileid']); 
$path = ManagerDataBase::ROOTPATH . $file->getPath() . $file->getFileName() ;

$listInfo = array([
    'id'        => $file->getFileID(),
    'name'      => $file->getFileName(),
    'size'      => File::formatBytes(File::getSizeFolder($path)),
      
]);
echo  json_encode(array('status' => true  , 'list' =>$listInfo));


?>