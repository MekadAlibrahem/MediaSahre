<?php 
include_once "../class.Admin.php" ; 
use MediaShare\Users\Admin ;

$sizeMemory = Admin::getAllMemoryInServer();
if($_POST['newSize'] != $sizeMemory){
    Admin::setAllMemory($_POST['newSize']);
    $sizeMemory = Admin::getAllMemoryInServer();
    echo json_encode(array('status' => true , 'size' => $sizeMemory ));
}else{
    echo json_encode(array('status' => false , 'error' =>  'إن هذه القيمة مسجلة بالفعل ' ));

}

?>