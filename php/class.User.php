<?php 
namespace MediaShare\Users ;

use Exception;
use MediaShare\Files\File;

    include_once "class.visitor.php" ;

    class User extends  Visitor {
        public $userID   ;
        public $userName ; 
        public $email    ;
        public $password ;
        

        //constructer

        private function __construct(){
            //dont delete this method
        }
        /** @todo  return user object 
         * @param       int     $userID 
         * @return       User|string   return user object | error message if somthing wrong 
         */
        public static  function creatUser($userID){
            try{
                $user = new self();
                $listinfo = ManagerUsersDB::getUserinfo($userID);
                if(is_array($listinfo)){
                    $user->userID       = $userID ;
                    $user->userName     = $listinfo['userName']; 
                    $user->email        = $listinfo["email"] ;
                    $user->password     = $listinfo['password'];
                    
                    return $user ;
                }
            }catch(Exception $e){
                return $e->getMessage();
            }
         } 
       
        //set Method 
        public function setUserID($id){$this->userID = $id;}
        public function setUserName($userName){$this->userName = $userName;} 
        public function setEmail($email){$this->email = $email;}
        public function setPassword($password){$this->password = $password;}
        //get method 
        public function getUserID(){return $this->userID;}
        public function getUserName() {return $this->userName; }
        public function getEmail(){return $this->email;}
        public function getPassword(){return $this->password;}
        //
        /** @todo edit user name  
         * @param       string      $newUserName  
         * @return      bool|string : return true if edit eles that false | error message if somthing wrong 
         */
        public  function editUserName($newUserName){
            try {
                if(ManagerUsersDB::isUserNameUsed($newUserName)) return "إن هذا الاسم مستخدم سابقا  " ;
                if(ManagerUsersDB::updateUserName($this->getUserID() , $newUserName ) ){
                    $this->setUserName($newUserName);
                    $fileID = File::getRootFileFromUser($this->getUserID());
                    $file = File::CreatObject($fileID);
                    if($file instanceof File){
                        $isEdit = $file->editName($newUserName);
                        if($isEdit){
                            return true ;
                        }
                    }
                }
                    return false; 
                
            } catch (Exception $e) {
                return $e->getMessage() ;
            }
         }
        //
        /** @todo edit  email  
         * @param       string      $newemail  
         * @return      bool|string : return true if edit eles that false | error message if somthing wrong 
         */
        public  function editEmail($newemail){
            try {
                if(ManagerUsersDB::isEmailUsed($newemail)) return "هذا البريد الالكتروني مستخدم سابقا " ;
                if(ManagerUsersDB::updateUserEmail($this->getUserID() , $newemail) ){
                    $this->setEmail($newemail);
                    return true  ;
                }else{
                    return false; 
                }
            } catch (Exception $e) {
                return $e->getMessage() ;
            }
         }
        //
        /** @todo edit password  
         * @param       string      $oldPassword
         * @param       string      $newPassword 
         * @param       string      $confirmPassword   
         * @return      bool|string : return true if edit eles that false | error message if somthing wrong 
         */
        public  function editPassword($oldPassword , $newPassword , $confermPassword){
            try {
                if($oldPassword == $this->getPassword()){
                    if(self::isValidPassword($newPassword , $confermPassword)){
                        if(ManagerUsersDB::updatePassword($this->getUserID() , $newPassword) ){
                            $this->setPassword($newPassword);
                            return true  ;
                        }else{
                            return false; 
                        }
                    }else{
                            return "كلمة المرور و تأكيدها غير متطابقين  " ;
                    }   
                }else{
                    return "كلمة المرور غير صحيحة " ;
                } 
                 
            } catch (Exception $e) {
                return $e->getMessage() ;
            }
         }
        //

        /** @todo delete user account 
         * @return      bool|string         true if delete account | error message 
         */
        public function deleteAccount(){
            try{
                if(self::class != Admin::class){
                    $isDeleteFiles =  File::delete(File::getRootFileFromUser($this->getUserID()));
                    $isDeleteUser  =   ManagerUsersDB::deleteUserFromDataBase($this->getUserID());
                    return true;  
                }
                
            }catch(Exception $e){
                return $e->getMessage();
            }
         }
        //

        /** @todo return how match user used in his space of server 
         * @return        int|string        value of user used | error Message 
         * 
         */ 
        public static function getUserStorag($userID){
            try{
                $totalspase = ManagerUsersDB::getTotalSpase($userID);
                return $totalspase ;
            }catch(Exception $e){
                return $e ;
            }
        }

        public static function convertB2GB($B){
            return $B / 1024 / 1024  /1024 ;
        }
        public  static function getSpaseUsed($userID){
            try{
                $size = File::getRootFileSizeForUser($userID);
                $formatSize = self::formatBytes($size);
                $size = self::convertB2GB($size);
                $totalspase     =  self::getUserStorag($userID);
                return array("size" => $size  , "totalsize" => $totalspase , "formatSize" =>$formatSize);
            }catch(Exception $e){
                return $e->getMessage();
            }
        }

        public static  function payMemory($userID , $account , $password , $space){
            try{
                $totalPrice = $space * ManagerUsersDB::getPriceMemory() ;
                $accountBalance = ManagerUsersDB::getCountInBankAccount($account , $password);
                if($accountBalance < $totalPrice ){
                    return self::errorLog("لا يوجد رصيد كافي في الحساب ");
                }else{
                    $paid =  ManagerUsersDB::paid($account , $password ,$totalPrice) ;
                    if($paid ===true){
                        $add = ManagerUsersDB::addSpaceForUser($userID , $space);
                        if($add === true) return true ;
                    }
                }
                

            }catch(Exception $e){
                return $e ;
            }
           
        }
        public static function convertGB2B($GB){
            return $GB * 1024 * 1024 * 1024 ;
        }


        // دالة لتحويل بين قيم حجم الملفات 
        public static function formatBytes($bytes, $precision = 2) { 
            $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
        
            $bytes = max($bytes, 0); 
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
            $pow = min($pow, count($units) - 1); 
            $bytes /= pow(1024, $pow);

        
            return round($bytes, $precision) . '' . $units[$pow]; 
        }

        public static function freeSpaceToUser($userID){
            $memoryUsed = File::getRootFileSizeForUser($userID);
            $totalmemory  =  self::getUserStorag($userID);
            return self::convertGB2B($totalmemory) - $memoryUsed ;
        }

    }



?>