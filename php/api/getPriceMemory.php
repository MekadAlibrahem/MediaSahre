
<?php 
include_once "../class.Admin.php" ; 
use MediaShare\Users\Admin ;

$price = Admin::getPriceUnitMemory();
echo json_encode(array('status' => true , 'price' => $price ));

?>