<?php
include_once "../php/class.ManagerDataBase.php" ;
use MediaShare\ManagerDataBase;
$file =  ManagerDataBase::FOLDERDOWNLOAD . "1648466908folder2.zip";
$quoted = basename($file) ;
$size   = filesize($file);
echo $file ."<br>" ;
echo $quoted ."<br>" ; 
$infoFile =  pathinfo($file);
if(file_exists($file)){
    
    header('Content-Description: File Transfer');
    if($infoFile['extension'] == 'zip'){
        // header('Content-Type: application/zip');
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' .$quoted);
        header('Content-Length: ' . $size);
        echo "zip" ;
    }else{
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $quoted); 
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        
    }
   
    readfile($file , true );
    
}
else{
    echo 'not found ' ;
}




// include_once "../class.ManagerDataBase.php";
// $filezipName  = $_GET['f'];
// header('Content-Type: application/zip');
// header('Content-disposition: attachment; filename='.$filezipName);
// header('Content-Length: ' . filesize($filezipName));
// readfile(ManagerDataBase::TEMPFOLDER . $filezipName , true);
// unlink(ManagerDataBase::TEMPFOLDER.$filezipName);


?>