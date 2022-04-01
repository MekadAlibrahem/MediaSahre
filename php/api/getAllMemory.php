<?php 
include_once "../class.Admin.php" ; 
use MediaShare\Users\Admin ;

$sizeMemory = Admin::getAllMemoryInServer();
echo json_encode(array('status' => true , 'size' => $sizeMemory ));

?>