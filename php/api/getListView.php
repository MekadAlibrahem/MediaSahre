<?php
include_once "../class.User.php" ;
use MediaShare\Files\File ;
use MediaShare\Users\User ;
// data:{'fileeid': fileid , 'viewEmail' : viewEmail , 'userid' : userid},
try{
    $listIDUser = File::getListViewToFile($_POST['fileid'] ,$_POST['userid']);
    if(!empty($listIDUser)){
        $listView = array(); 
        foreach ($listIDUser as $id) {
            $user = User::creatUser($id);
            array_push($listView , 
                [
                    'name'=>$user->getUserName() ,
                    "id"  =>$user->getUserID()
                ]
            );
        }
        echo json_encode(array('status'=> true ,  'listView'=>$listView));
    }else{
        echo json_encode(array('status'=> false , 'error'=>"لا يوجد اي مستخدم "));

    }
    
  

}catch(Exception $e){
    echo json_encode(array('status'=> false , 'error'=>$e->getMessage()));

}

?>