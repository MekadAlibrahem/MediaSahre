<?php 
   
    // require "../php/class.visitor.php" ;
    // use MediaShare\Visitor ;
    // require "../php/class.ManagerUsersDB.php" ;
    // use MediaShare\ManagerUsersDB ;
        include "../php/class.User.php" ;
        

// use MediaShare\ManagerUsersDB;

use MediaShare\ManagerUsersDB;
use MediaShare\Users\User ;
use MediaShare\Users\Visitor;
use MediaShare\Users\Admin;

    try {
    //    $isInsert =  ManagerUsersDB::insertUserToDataBase("test2" , "test2@email.com" , "test");
    //    if($isInsert) echo "insert user </br>" ;
    //    $isName   = ManagerUsersDB::checkUserNameIsStored("test2");
    //    if($isName) echo "this name is used befor </br> " ;
    //    $email   = ManagerUsersDB::checkEmailIsStored("test2@email.com");
    //    if($email) echo "this email is used befor </br>" ;
    //    $isUpdate = ManagerUsersDB::updateUserName(10 , "test2");
    //    if($isUpdate) echo "update user name </br> " ;
    //    $isUpdate = ManagerUsersDB::updateUserType(10 , 1);
    //    if($isUpdate) echo "update user type </br> " ;
        // $user = User::creatUser(10) ;
        // // $user = User::getUserinfo(10);
        // echo "<pre>" ;
        // print_r($user);
        // echo "</bre>" ;
        $userid = Visitor::logIn("test3" ,  "user3" );
        if(isset($userid)){
            echo $userid ;
        }
        // $user->editUserName("asdsd");
    


    } catch (Exception $e) {
        echo $e->getMessage();
    }

    
    
    
    
?>