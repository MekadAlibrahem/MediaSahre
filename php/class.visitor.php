<?php
namespace MediaShare\Users ;

use Exception;
include_once "class.File.php";
include_once "class.ManagerUsersDB.php" ;
use MediaShare\Files\File;

class Visitor extends ManagerUsersDB {
        const PUBLICPATH = "http://localhost/mediashare/public/html" ;
        public function __construct(){

        }
        
        /**
         * download file in user devise  
         * 
         */
        
        
        
        /** @todo create new account 
         * @param       string       $username
         * @param       string       $email
         * @param       string       $password               
         * @param       string       $confermPassowrd      
         * @return      true|string  : true if create | error message if somthing wrong  
         * 
         */
        public  static function createNewAccount($userName , $email , $password , $confermPassword ){
            try{
                if(empty($email ) || empty($userName) ||empty($password)  ) return ' يجب إدخال قيم اولا ' ;
                if(self::class!=static::class) return ;
                if(ManagerUsersDB::isUserNameUsed($userName)) return " إن إسم المستخدم قد استخدم سابقا " ;
                if(ManagerUsersDB::isEmailUsed($email)) return  "إن هذا البريد الالكتروني مستخدم سابقا " ;
                $isValidPassword  = self::isValidPassword($password , $confermPassword) ; 
                if($isValidPassword){
                    $isCreate =  ManagerUsersDB::insertUserToDataBase($userName , $email , $password  );
                    $isCreateFolder = File::newFolder(-1, $userName , intVal(ManagerUsersDB::getUserIdByUserName($userName)), File::PRIVATE_FILE);
                    return true ;
                }
            }catch(Exception $e){
                return $e->getMessage();
            }
            
        }

        /** @todo this function check is password  if valid 
         * @param       string      $password               : new password  ;
         * @param       string      $confermPassowrd        :  conferm password 
         * @return      true|Exception  : true if valid |exception object with error message 
         * 
         */
        protected static function isValidPassword($password , $confermPassword){
            $MINLINGTHPASSWORD = 3 ;
            if($password === $confermPassword){
                if(strlen($password)>$MINLINGTHPASSWORD) {
                    return true ;
                }else{
                    return ManagerUsersDB::errorLog("يرجى إدخال كلمة مرور اطول") ;
                }
            }else{
                return ManagerUsersDB::errorLog("إن كلمة المرور و تاكيدها غير متطابقان") ;
                
            }
        }
        // ضيف شرح 
        public static function logIn($userName  , $password){
            try {
                $type = ManagerUsersDB::getTypeUserByUserName($userName) ;
                if($type == ManagerUsersDB::NOURMAL_USER){
                    $user = User::creatUser(ManagerUsersDB::getUserIdByUserName($userName));
                    if($password == $user->getPassword()){
                        User::updataLastLogIn($user->getUserID());
                    return $user ;
                    }else{
                        return "كلمة مرور غير صحيحة " ;
                    }
                }else if($type == ManagerUsersDB::ADMIN_USER){
                    $admin  = User::creatUser(ManagerUsersDB::getUserIdByUserName($userName));
                    if($password == $admin->getPassword()){
                        User::updataLastLogIn($admin->getUserID());
                        return $admin ;
                    }else{
                        return "كلمة مرور غير صحيحة " ;
                    }
                }else{
                    return "error" ;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
            
        
        

    }

    

?>