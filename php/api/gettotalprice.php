<?php 
session_start();
include_once "../class.User.php" ;

use MediaShare\Users\ManagerUsersDB;
use MediaShare\Users\User ;

$totalPrice = $_POST['count'] * ManagerUsersDB::getPriceMemory() ;

echo  json_encode(array( "status" => true , 'price'=>$totalPrice  ));

  


?>