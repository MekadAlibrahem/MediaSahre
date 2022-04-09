<?php
include_once "../../class.ManagerDataBase.php" ;
use MediaShare\ManagerDataBase;
$file =  __DIR__ .'\\'. $_GET['f'];
$quoted = basename($file) ;
$size   = filesize($file);
echo $file ."<br>" ;
echo $quoted ."=> qq <br>" ; 
$infoFile =  pathinfo($file);
$file_extension =  $infoFile['extension'] ;
if(file_exists($file)){
    
    header('Content-Description: File Transfer');
    if($infoFile['extension'] == 'zip'){
        // header('Content-Type: application/zip');
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' .$quoted);
        header('Content-Length: ' . $size);
        echo "zip" ;
    }else{
        header("Content-Type: application/$file_extension");
        header('Content-Disposition: attachment; filename=' . $quoted); 
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        
    }
   
    readfile($file , true );
    // unlink($file);
    
}
else{
    echo 'not found ' ;
}


die();



// include_once "../class.ManagerDataBase.php";
// $filezipName  = $_GET['f'];
// header('Content-Type: application/zip');
// header('Content-disposition: attachment; filename='.$filezipName);
// header('Content-Length: ' . filesize($filezipName));
// readfile(ManagerDataBase::TEMPFOLDER . $filezipName , true);


?>