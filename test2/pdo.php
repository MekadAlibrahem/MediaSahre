<?php
// include_once "../php/class.ManagerDataBase.php" ;
include_once "../php/class.FIle.php" ;
use MediaShare\Files\File ;
    $re = File::newFile(-1 , "pdo.txt" , 8 , 1 , 70);
    if($re === true){
        echo "done" ; 
    }else{
        echo "false" ;
    } 
?>