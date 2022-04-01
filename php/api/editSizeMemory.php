<?php 
include_once "../class.Admin.php" ; 
use MediaShare\Users\Admin ;

$sizeMemory = Admin::getDefaultMemory();
if($_POST['newSize'] != $sizeMemory){
    Admin::setDefaultMemory($_POST['newSize']);
    $sizeMemory = Admin::getDefaultMemory();
    echo json_encode(array('status' => true , 'size' => $sizeMemory ));
}else{
    echo json_encode(array('status' => false , 'error' =>  'إن هذه القيمة مسجلة بالفعل ' ));

}

?>