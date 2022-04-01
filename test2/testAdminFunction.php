<?php 
include_once "../php/class.Admin.php" ; 
use MediaShare\Users\Admin ; 
// $admin = Admin::CreateAdmin(14);
// $list  = Admin::getAllUser();

// echo "<pre>" ; 
// print_r($list);
// echo "</pre>" ;
// echo "<br/>" . Admin::getAllMemoryUsed() ;
Admin::setAllMemory(12312);
echo Admin::getAllMemory();

?>