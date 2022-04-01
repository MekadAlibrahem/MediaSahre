<?php 
    require "../php/class.ManagerDataBase.php" ;

    $con =  MediaShare\ManagerDataBase::connectDataBase();
    if($con){
        echo "true";
    } 

?>