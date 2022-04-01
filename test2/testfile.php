<?php 
include_once "../php/class.File.php" ;
use MediaShare\Files\File ;
use MediaShare\ManagerDataBase;
    
    try {
        $file = File::CreatObject(-1, "testfolder3" , 8 , 39 , 2);
        echo "<pre>" ;
        print_r($file); 
        echo "</pre>" ;
    } catch (Exception $th) {
        print($th->getMessage());
    }

   

    

  
?>