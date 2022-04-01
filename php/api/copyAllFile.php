<?php
include_once "../class.File.php";

use MediaShare\Files\File ;

try {
    $listFile = $_POST['listFile'];
    $result  = "" ;
    foreach ($_POST['listFile'] as  $sourceFile) {
        
        $isCopy = File::copy($sourceFile , $_POST['destFile'] );
        if($isCopy === true){
            
        }else{
            $result .=  $isCopy ;
        }
    }
    echo json_encode(array("status" => true , "result" => $result ,"f" => "6"  ));


   
} catch (Exception $e) {
    echo json_encode(array("status" => false , "error" => $e->getMessage()));
}







?>