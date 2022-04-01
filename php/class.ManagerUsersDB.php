<?php 
namespace MediaShare\Users ;

use Exception;
use MediaShare\ManagerDataBase;
include_once "class.ManagerDataBase.php";


     class ManagerUsersDB extends ManagerDataBase{
        //users Type 
        const NOURMAL_USER  = 2 ;
        const ADMIN_USER    = 1 ;
        //
        const SETTING_PATH  ="C://xampp/htdocs/MediaShare/php" ;
        const SETTING_FILE  = 'settings.json' ;        
        const SETTING_FILE_DEFAULT_MEMORY   =  "default_memory" ;
        const SETTING_FILE_PRICE_MEMORY     = "price_memory" ;
        const SETTING_FILE_ALL_MEMORY       = "all_memory" ;

        


        /** @todo  insert new User  in database 
         * @param       string      $userName   :  user name  
         * @param       string      $email      :  user email 
         * @param       string      $password   : passowrd account from this user 
         * @return      true|Exception        if user inserted | Exception object with Message Error 
         * 
         */
        public static function insertUserToDataBase($userName , $email , $password){
            $default_memory = self::getDefultSizeMemory();
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "INSERT INTO `".ManagerDataBase::USERSTABLE."`(
                    `".ManagerDataBase::USERSTABLE_USERID."`,
                    `".ManagerDataBase::USERSTABLE_USERNAME."`,
                    `".ManagerDataBase::USERSTABLE_EMAIL."`,
                    `".ManagerDataBase::USERSTABLE_PASSWORD."` ,
                    `".ManagerDataBase::USERSTABLE_STORAG."` )
                 VALUES(null,'$userName','$email','$password' ,'". $default_memory ."' ); " ;
               
                $isCreate = mysqli_query($contact_handle ,$sql);
                if($isCreate){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return self::errorLog($contact_handle->erroe) ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
       
        
        /** @todo check email if used befor (stored ) in database 
         * @param       string          $email      : email we will check it  
         * @return      bool|Exception  : true if used  else that return false | Exception object with message Error 
         */
        public static function isEmailUsed($email){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT * FROM `".ManagerDataBase::USERSTABLE."` 
                WHERE `".ManagerDataBase::USERSTABLE_EMAIL."` = '$email' " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        
         }
        //
        /** @todo check userName if used befor (stored ) in database 
         * @param       string          $userName      : userName we will check it  
         * @return      bool|Exception  : true if used  else that return false | Exception object with message Error 
         */
        public static function isUserNameUsed($userName){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT * FROM `".ManagerDataBase::USERSTABLE."` 
                WHERE `".ManagerDataBase::USERSTABLE_USERNAME."` = '$userName' " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        
        
        
        // update infrmation for user
        //
        /** @todo update user name in database 
         * @param       int         $userID     : user id  
         * @param       string      $newUserName 
         * @return      bool|Exception      :true if update user name else that false | Excption object with Error message
         */ 
        public static function updateUserName($userID , $newUserName ){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        UPDATE `".ManagerDataBase::USERSTABLE."` 
                        SET  `".ManagerDataBase::USERSTABLE_USERNAME."` = '$newUserName' 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        /** @todo update user email in database 
         * @param       int         $userID     : user id  
         * @param       string      $newEmail 
         * @return      bool|Exception      :true if update user email else that false | Excption object with Error message
         */ 
        public static function updateUserEmail($userID , $newEmail ){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        UPDATE `".ManagerDataBase::USERSTABLE."` 
                        SET  `".ManagerDataBase::USERSTABLE_EMAIL."` = '$newEmail' 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        /** @todo update password for user account in database 
         * @param       int         $userID     : user id  
         * @param       string      $newPassword 
         * @return      bool|Exception      :true if update password else that false | Excption object with Error message
         */ 
        public static function updatePassword($userID , $newPassword ){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        UPDATE `".ManagerDataBase::USERSTABLE."` 
                        SET  `".ManagerDataBase::USERSTABLE_PASSWORD."` = '$newPassword' 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        /** @todo update user type for user account in database 
         * @param       int         $userID     : user id  
         * @param       string      $newUserType 
         * @return      bool|Exception      :true if update user type else that false | Excption object with Error message
         */ 
        public static function updateUserType($userID , $newUserType ){
            if(self::class != Admin::class) return  self::errorLog("You dont have access ");
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        UPDATE `".ManagerDataBase::USERSTABLE."` 
                        SET  `".ManagerDataBase::USERSTABLE_TYPEUSER."` = '$newUserType' 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        /** @todo delete user in database 
         * @param       int         $userID     : user id  
         * @return      bool|Exception      :true if delete account else that false | Excption object with Error message
         */ 
        public static function deleteUserFromDataBase($userID){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        DELETE FROM `".ManagerDataBase::USERSTABLE."` 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        /** @todo  تعديل تاريخ اخر عملية تسجيل دخول للموقع 
         * @param       int         $userID     : user id  
         * @return      bool|Exception      :true if update last login else that false | Excption object with Error message
         */
        public static function updataLastLogIn($userID){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        UPDATE `".ManagerDataBase::USERSTABLE."` 
                        SET  `".ManagerDataBase::USERSTABLE_LASTLOGIN."` =  CURRENT_DATE()
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
               
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }
        //
        /** @todo add space to user 
         * @param       int         $userID 
         * @param       int         $count 
         * @return      true|Exception      true if add done  |Exception Object with error message 
         */
        public static function addSpaceForUser($userID ,$count){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        UPDATE `".ManagerDataBase::USERSTABLE."` 
                        SET  `".ManagerDataBase::USERSTABLE_STORAG."` = `".ManagerDataBase::USERSTABLE_STORAG."` + '$count' 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ; 
                    }else{
                        return false ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }
        //

        //get user information 
        /** @todo return user informaton 
         * @param         int       $userID 
         * @return      array|Exception        array information | Exception object with error message 
         */
        public static function getUserinfo($userID) {
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "
                        SELECT  
                            `".ManagerDataBase::USERSTABLE_USERNAME."`   as 'userName' ,
                            `".ManagerDataBase::USERSTABLE_EMAIL."`      as 'email' ,
                            `".ManagerDataBase::USERSTABLE_PASSWORD."`   as 'password'    
                        FROM `".ManagerDataBase::USERSTABLE."` 
                        WHERE   `".ManagerDataBase::USERSTABLE_USERID."` = '$userID' ;
                " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $list = array(); 
                        while ($row = mysqli_fetch_array($query)) {
                          
                           $list = array( "userName" => $row['userName'],
                                            "email" => $row['email'] ,
                                            "password" => $row['password'] ,
                                           
                                         );
                        }
                        return $list ;
                    }else{
                        return self::errorLog("not found this user account ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }

            
        //
        
        /** @todo return user id from database by user name 
         * @param      string       $userName 
         * @return      int|Exception        id user | Exception object with error message 
         */
        public static function getUserIdByUserName($userName){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT  `".ManagerDataBase::USERSTABLE_USERID."`
                        FROM `".ManagerDataBase::USERSTABLE."` 
                        WHERE `".ManagerDataBase::USERSTABLE_USERNAME."` = '$userName'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        
                        while ($row = mysqli_fetch_array($query)){ 
                           $list = $row[0];
                        }
                        return $list ;
                    }else{
                        return self::errorLog("not found this user account ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
        /** @todo return user type from database by user name 
         * @param      string       $userName 
         * @return      int|Exception        id type user | Exception object with error message 
         */
        public static function getTypeUserByUserName($userName){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT  `".ManagerDataBase::USERSTABLE_TYPEUSER."`
                        FROM `".ManagerDataBase::USERSTABLE."` 
                        WHERE `".ManagerDataBase::USERSTABLE_USERNAME."` = '$userName'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        
                        while ($row = mysqli_fetch_array($query)){ 
                           $list = $row[0];
                        }
                        return $list ;
                    }else{
                        return self::errorLog("not found this user account ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
         }
        //
         /** @todo  تعيد المساحة التخزينية المخصصة لمستخدم ما 
          * @param    int       $userID           : id user 
          * @return   int|Exception        : space | Exception object with Error Message   
          */
        public static function getTotalSpase($userID){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT  `".ManagerDataBase::USERSTABLE_STORAG."` as 'space'
                        FROM `".ManagerDataBase::USERSTABLE."` 
                        WHERE `".ManagerDataBase::USERSTABLE_USERID."` = '$userID'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        while ($row = mysqli_fetch_array($query)){ 
                            $r =    $row['space'];
                        }
                        return $r ;
                    }else{
                        return self::errorLog("not found this user account ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }

        //

        /** @todo  سحب مبلغ معين من حساب مصرفي 
         * @param       string      $account   : name account  
         * @param       string      $password   :password for bank account 
         * @param       int         $count      : how match count need 
         * @return      true|Excepion       : true if paid done | Exception Object with Error Message 
         * 
         */
        public static function paid($account , $password  , $count){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "UPDATE `".ManagerDataBase::BANKTABLE."` 
                        SET `".ManagerDataBase::BANKTABLE_COUNT."` =  `".ManagerDataBase::BANKTABLE_COUNT."` - $count 
                        WHERE `".ManagerDataBase::BANKTABLE_ACCOUNT."` = '$account' 
                            AND `".ManagerDataBase::BANKTABLE_PASSWORD."` = '$password'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ;
                    }else{
                        return self::errorLog(" الحساب المصرفي غير موجود او كلمة المرور غير صحيحة ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }

        /** @todo   تعيد قيمة الرصيد المتوفر في حساب ما 
         * @param        string    $account   : user bank account 
         * @param        string    $password    :password for bank account 
         * @return       int|Exception    : count  | Exception object with Error Message    
         */
        public static function getCountInBankAccount($account , $password){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT  `".ManagerDataBase::BANKTABLE_COUNT."` as 'count'
                        FROM `".ManagerDataBase::BANKTABLE."` 
                        WHERE `".ManagerDataBase::BANKTABLE_ACCOUNT."` = '$account' 
                            AND `".ManagerDataBase::BANKTABLE_PASSWORD."` = '$password'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        while ($row = mysqli_fetch_array($query)){ 
                            $count  =    $row['count'];
                        }
                        return $count ;
                    }else{
                        return self::errorLog("not found this user account ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }
        /** @todo  إضافة رصيد في حساب مصرفي  
         * @param       string      $account   : name account  
         * @param       string      $password   :password for bank account 
         * @param       int         $count      : how match count need 
         * @return      true|Excepion       : true if paid done | Exception Object with Error Message 
         * 
         */
        public static function addCountToBankAccount($account , $password  , $count){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "UPDATE `".ManagerDataBase::BANKTABLE."` 
                        SET `".ManagerDataBase::BANKTABLE_COUNT."` =  `".ManagerDataBase::BANKTABLE_COUNT."` + $count 
                        WHERE `".ManagerDataBase::BANKTABLE_ACCOUNT."` = '$account' 
                            AND `".ManagerDataBase::BANKTABLE_PASSWORD."` = '$password'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ;
                    }else{
                        return self::errorLog(" الحساب المصرفي غير موجود او كلمة المرور غير صحيحة ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }

        /** @todo  إضافة حساب مصرفي جديد
         * @param       string      $account      :name accounr 
         * @param       string      $password      :password account 
         * @param       int         $count         how match count we need  
         * @return      true|Excepion       : true if paid done | Exception Object with Error Message 
         * 
         */
        public static function insertNewBankAccount($account , $password , $count){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "INSERT INTO `".ManagerDataBase::BANKTABLE."` 
                        VALUES(null , '$account' ,'$password' ,'$count') ;
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ;
                    }else{
                        return self::errorLog(" لم يتم إضافة الحساب ربما اسم الحساب هذا مستخدم بالفعل ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }
        /** @todo حذق حساب مصرفي 
         * @param       string      $account      :name accounr 
         * @param       string      $password      :password account 
         * @return      true|Excepion       : true if paid done | Exception Object with Error Message 
         * 
         */
        public static function deleteBankAccount($account , $password){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "DELETE FROM  `".ManagerDataBase::BANKTABLE."` 
                        WHERE `".ManagerDataBase::BANKTABLE_ACCOUNT."` = '$account' 
                        AND `".ManagerDataBase::BANKTABLE_PASSWORD."` = '$password'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ;
                    }else{
                        return self::errorLog(" لم يتم حذف الحساب ربما كلمة المرور او اسم الحساب غير صحيح   ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        
        }

        /** @todo  تعديل رصيد حساب مصرفي  
         * @param       string      $account   : name account  
         * @param       string      $password   :password for bank account 
         * @param       int         $count      : how match count need 
         * @return      true|Excepion       : true if paid done | Exception Object with Error Message 
         * 
         */
        public static function updateCountToBacnkAccount($account , $password  , $count){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "UPDATE `".ManagerDataBase::BANKTABLE."` 
                        SET `".ManagerDataBase::BANKTABLE_COUNT."` =   $count 
                        WHERE `".ManagerDataBase::BANKTABLE_ACCOUNT."` = '$account' 
                            AND `".ManagerDataBase::BANKTABLE_PASSWORD."` = '$password'
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        return true ;
                    }else{
                        return self::errorLog(" الحساب المصرفي غير موجود او كلمة المرور غير صحيحة ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }
        /** @todo   تعيد جميع الحسابات المصرفية
         * @return       array|Exception    : list account  | Exception object with Error Message    
         */
        public static function getAllBankAccount(){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "SELECT   `".ManagerDataBase::BANKTABLE_ACCOUNT."` as 'name' ,
                        `".ManagerDataBase::BANKTABLE_PASSWORD."` as 'password' ,
                        `".ManagerDataBase::BANKTABLE_COUNT."` as 'count'
                        FROM `".ManagerDataBase::BANKTABLE."`
                        WHERE 1 
                       
                    " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    $list = array();
                    if(mysqli_affected_rows($contact_handle)>0){
                        while ($row = mysqli_fetch_array($query)){ 
                            array_push($list ,[
                                'name'=>$row['name'] , 
                                'password'=>$row['password'],
                                'count'=>$row['count']
                            ]);
                        }
                        return $list;
                    }else{
                        return self::errorLog("not found this user account ") ;
                    }
                }else{
                    return self::errorLog($contact_handle->erroe) ;
                }
            }else{
                return self::errorLog($contact_handle);
            }
        }
       

     
        // method for admin only  
        /** @todo   تعيد قائمة بحسابات المستخدمين المجسلين في الموقع   
         * @return    array|Exception     : list of user account  | Exception Object with error message 
         */
        public static function getAllUser(){
            if(get_called_class() !=Admin::class) return "لاتملك الصلاحية لتنفيذ ذلك" ;
                $contact_handle = ManagerDataBase::connectDataBase(); 
                if($contact_handle){
                    $sql = "
                            SELECT  
                                `".ManagerDataBase::USERSTABLE_USERID."` as 'id' ,
                                `".ManagerDataBase::USERSTABLE_USERNAME."`   as 'userName' ,
                                `".ManagerDataBase::USERSTABLE_EMAIL."`      as 'email' ,
                                `".ManagerDataBase::USERSTABLE_LASTLOGIN."`   as 'lastLogin',
                                `".ManagerDataBase::USERSTABLE_STORAG."` as 'memory'    
                            FROM `".ManagerDataBase::USERSTABLE."` 
                            ORDER BY  `".ManagerDataBase::USERSTABLE_LASTLOGIN."` DESC ;
                    " ;
                    $query = mysqli_query($contact_handle ,$sql);
                    if($query){
                        if(mysqli_affected_rows($contact_handle)>0){
                            $list = array(); 
                            while ($row = mysqli_fetch_array($query)) {
                              
                                array_push($list ,[
                                                "id"        => $row['id'],
                                                "userName"  => $row['userName'],
                                                "email"     => $row['email'] ,
                                                "lastLogin" => $row['lastLogin'],
                                                "memory"    => $row['memory']
                                            ]);
                            }
                            return $list ;
                        }else{
                            return self::errorLog(" لا يوجد اي حساب ") ;
                        }
                    }else{
                        return self::errorLog($contact_handle->erroe) ;
                    }
                }else{
                    return self::errorLog($contact_handle);
                }
            
            
            
        }
        // 
        /** @todo تعيد عدد حسابات المستخدمين في الموقع 
         * @return   int|Exception    count memory used in server | Exceptionobject with error Message 
         */
        public static function getCountUserAccount(){
            if(get_called_class() !=Admin::class) return "لاتملك الصلاحية لتنفيذ ذلك" ;
            $contact_handle = ManagerDataBase::connectDataBase(); 
                if($contact_handle){
                    $sql = "SELECT  COUNT(`".ManagerDataBase::USERSTABLE_USERID."`)
                            FROM `".ManagerDataBase::USERSTABLE."`  
                    " ;
                    $query = mysqli_query($contact_handle ,$sql);
                    if($query){
                        if(mysqli_affected_rows($contact_handle)>0){
                            
                            while ($row = mysqli_fetch_array($query)) {
                              
                                return $row[0];
                            }
                           
                        }else{
                            return self::errorLog(" لا يوجد اي حساب ") ;
                        }
                    }else{
                        return self::errorLog($contact_handle->erroe) ;
                    }
                }else{
                    return self::errorLog($contact_handle);
                }
            
        }
               // 
        /** @todo تعيد كمية الذاكرة المحجوزة لجميع المستخدمين 
         * @return   int|Exception    count memory used in server | Exceptionobject with error Message 
         */
        public static function getAllMemoryUsed(){
            if(get_called_class() !=Admin::class) return "لاتملك الصلاحية لتنفيذ ذلك" ;
            $contact_handle = ManagerDataBase::connectDataBase(); 
                if($contact_handle){
                    $sql = "SELECT  SUM(`".ManagerDataBase::USERSTABLE_STORAG."`)
                            FROM `".ManagerDataBase::USERSTABLE."`  
                    " ;
                    $query = mysqli_query($contact_handle ,$sql);
                    if($query){
                        if(mysqli_affected_rows($contact_handle)>0){
                            
                            while ($row = mysqli_fetch_array($query)) {
                              
                                return $row[0];
                            }
                           
                        }else{
                            return self::errorLog(" لا يوجد اي حساب ") ;
                        }
                    }else{
                        return self::errorLog($contact_handle->erroe) ;
                    }
                }else{
                    return self::errorLog($contact_handle);
                }
            
        }

        public static function getDefultSizeMemory(){
            $setting_file = self::SETTING_PATH."/".self::SETTING_FILE ;
            $settings = json_decode(file_get_contents($setting_file), true);
            return $settings[self::SETTING_FILE_DEFAULT_MEMORY] ?? null;       
        }
        public static function getPriceMemory(){
            $setting_file = self::SETTING_PATH."/".self::SETTING_FILE ;

            $settings = json_decode(file_get_contents($setting_file), true);
            return $settings[self::SETTING_FILE_PRICE_MEMORY] ?? null;       
        }
        public static function getAllMemory(){
            $setting_file = self::SETTING_PATH."/".self::SETTING_FILE ;

            $settings = json_decode(file_get_contents($setting_file), true);
            return $settings[self::SETTING_FILE_ALL_MEMORY] ?? null; 
        }

      


        
        
        /** @todo return throw new Exception with Error Message 
         * @param       string      $msg       error message 
         * @return      Exception   Exception with error message 
         */
        public static function errorLog($msg){
            return throw new Exception($msg);
        }
        //

     }

?>