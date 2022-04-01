<?php 
include_once "../php/class.User.php" ; 
use MediaShare\Users\User ;

$count  = User::deleteBankAccount("account2" , "account2" );
echo $count ;

?>