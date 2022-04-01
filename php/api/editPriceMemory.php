<?php 
include_once "../class.Admin.php" ; 
use MediaShare\Users\Admin ;

$sizeMemory = Admin::getPriceUnitMemory();
if($_POST['newSize'] != $sizeMemory){
    Admin::setPriceUnitMemory($_POST['newSize']);
    $price = Admin::getPriceUnitMemory();
    echo json_encode(array('status' => true , 'price' => $price ));
}else{
    echo json_encode(array('status' => false , 'error' =>  'إن هذه القيمة مسجلة بالفعل ' ));

}

?>