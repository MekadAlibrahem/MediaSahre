
<?php 
include_once "../class.Admin.php" ; 
use MediaShare\Users\Admin ;

$sizeMemory = Admin::getDefaultMemory();
echo json_encode(array('status' => true , 'size' => $sizeMemory ));

?>