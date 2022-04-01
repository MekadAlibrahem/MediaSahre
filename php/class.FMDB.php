<?php 
namespace MediaShare\Files {
    include_once "class.ManagerDataBase.php" ;
    use MediaShare\ManagerDataBase ;
    use Exception ;

    class FMDB extends ManagerDataBase {
        protected  const FILE_NOT_STORED = -1 ; 

        /**
         * method Insert information file to database  ;
         * @param       File             $file      : file object 
         * @return      bool|Exception              : true if insert done else false  | if found any error 
         */
        public  static function  insertFileToDataBase(File $file){
            $contact_handle = ManagerDataBase::connectDataBase();
            $result  = "" ;
            if($contact_handle){
                $parentid = !empty($file->getParentFile()) ? $file->getParentFile() : "NULL";
                $sql_insertFile = "INSERT INTO `".ManagerDataBase::FILETABLE."` 
                    (".ManagerDataBase::FILETABLE_FILEID." , ".ManagerDataBase::FILETABLE_FILENAME." ,
                    ".ManagerDataBase::FILETABLE_OWNER." , ".ManagerDataBase::FILETABLE_PARENTFILE." ,
                    ".ManagerDataBase::FILETABLE_TYPEFILE." , ".ManagerDataBase::FILETABLE_PATHFILE.")
                    VALUES(null , '$file->fileName' , $file->owner , $parentid
                        , $file->type ,'$file->path' )" ; 

                $query_insertFile = mysqli_query($contact_handle , $sql_insertFile);
                if($query_insertFile){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $result = true ;
                    }else{
                        $result = self::ErrorLog("Error message: file not stored  %s\n", $contact_handle->error ) ;
                    } 
                }else{
                    $result = self::ErrorLog("Error message: %s\n", $contact_handle->error  ) ;
                }
            }else{
                $result = self::ErrorLog($contact_handle) ;
            }
            
            mysqli_close($contact_handle);
            return  $result ;
        }
        /**
         * method to get detialls about file by id  
         * @param int : file id  
         * @return array|Exception :  array of information about file from dartbase |  if found any error 
         */
        public static function getFileByID($fileid){
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql_getFile = "SELECT 
                ".ManagerDataBase::FILETABLE_FILENAME." as 'name',
                ".ManagerDataBase::FILETABLE_OWNER." as 'owner',
                ".ManagerDataBase::FILETABLE_PARENTFILE." as 'parent',
                ".ManagerDataBase::FILETABLE_TYPEFILE." as 'type',
                ".ManagerDataBase::FILETABLE_PATHFILE." as 'path'
            FROM  `".ManagerDataBase::FILETABLE."`  
                            WHERE  `".ManagerDataBase::FILETABLE_FILEID."` = $fileid " ;
                $query = mysqli_query($contact_handle , $sql_getFile);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $file = mysqli_fetch_array($query);
                        return $file ;
                    }else{
                        return self::ErrorLog("Error message : file not  found in database") ; 
                    }
                }else{
                    return  self::ErrorLog("Error message: %s\n". $contact_handle->error  );
                }
            }else{
                return self::ErrorLog($contact_handle) ;
            }    
        }

        public static function getListChildrenID($paretnID){
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql_getAllFile = "SELECT  `".ManagerDataBase::FILETABLE_FILEID."`as 'id'
                                    FROM `".ManagerDataBase::FILETABLE."`
                                    WHERE `".ManagerDataBase::FILETABLE_PARENTFILE."` = $paretnID " ;
                $query = mysqli_query($contact_handle , $sql_getAllFile );
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $listID = array() ;
                        while($row =   mysqli_fetch_array($query)){
                            array_push($listID , $row['id']);
                        }  
                        return $listID ;
                    }else{
                        return false ;
                    }

                }else{
                    return self::ErrorLog("ERROR IN YOUR QUERY : " .$contact_handle->error);
                }
            }else{
                return self::ErrorLog( $contact_handle) ;
            }
        }

        //update file information
        /**
         * update file name in database  
         * @param File : file object 
         * @param String : new file name  
         * @return True|Exception : true if done | if found any error 
         */
        public static function updateFileName($file ,$newFileName){
            $result =  "" ;
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $id = $file->getFileID() ;
                $sql_updateFileName = "UPDATE `".ManagerDataBase::FILETABLE."` 
                SET `".ManagerDataBase::FILETABLE_FILENAME."` = '$newFileName'
                WHERE `".ManagerDataBase::FILETABLE_FILEID."` = '$id' " ; 
                $query_updateFileName = mysqli_query($contact_handle , $sql_updateFileName);
                if($query_updateFileName){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $result =  true  ; 
                    }else{
                        $result =  self::ErrorLog("fild update  file name " .$contact_handle->error);
                    } 
                }else{
                    $result =  self::ErrorLog("Error message: %s\n", $contact_handle->error ) ;
                }
            }else{
                $result =  self::ErrorLog($contact_handle);
            } 
            mysqli_close($contact_handle); 
            return $result ;
        }

        public static function updateFileType($fileid , $type){
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql = "UPDATE `".ManagerDataBase::FILETABLE."`  
                        SET `".ManagerDataBase::FILETABLE_TYPEFILE."` = '$type' 
                        WHERE  `".ManagerDataBase::FILETABLE_FILEID."` = '$fileid' ;
                " ;
                $query = mysqli_query($contact_handle , $sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0) return true ;
                    else return self::ErrorLog( "not file affected ");
                }else{
                    return self::ErrorLog( "Error in Your query :" .$contact_handle->error);
                }


            }else{
                return self::ErrorLog($contact_handle);
            }
        }
    

        //delet file 

        public static function DeleteFileInDB($fileID){
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql = "DELETE FROM `".ManagerDataBase::FILETABLE."`
                    WHERE `".ManagerDataBase::FILETABLE_FILEID."` = '$fileID' ;
                ";
                $query = mysqli_query($contact_handle,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0) return true ; 
                }else{
                    return self::ErrorLog("ERROR IN YOUR QUERY :" .$contact_handle->error);
                }
            }else{
                return self::ErrorLog($contact_handle);
            }
        }
        /**
         * method get  id last child insert in folder 
         * @param int                   $parentID   paretn folder id 
         * @return int|null|Excption    id last child file | null if folder is empty | excption error if found any error 
         */
        public static function getLastFileInFolder($ParentID){
            $parentFile = File::CreatObject($ParentID);
            if($parentFile instanceof File ){
                $contact_handle = ManagerDataBase::connectDataBase();
                if($contact_handle){
                    $sql = "SELECT MAX(`".ManagerDataBase::FILETABLE_FILEID."`) 
                    FROM `".ManagerDataBase::FILETABLE."`  
                    WHERE `".ManagerDataBase::FILETABLE_PARENTFILE."` = $ParentID " ;
                    $query = mysqli_query($contact_handle,$sql) ;
                    if($query){
                        if(mysqli_affected_rows($contact_handle)>0){
                            
                            while($row = mysqli_fetch_array($query)  ) {
                            return $row[0];
                            }
                            
                        }else{
                            return self::ErrorLog("this folder is empty");
                        }
                    }else{
                        return self::ErrorLog("ERROR MESSAGE :" . $contact_handle->error);
                    }
                }else{
                    return self::ErrorLog($contact_handle);
                }
            }else{
            return $parentFile ;
            }
        }
        public static function getRootFileFromUser($owner){
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql = "SELECT MIN(`".ManagerDataBase::FILETABLE_FILEID."`) 
                    FROM `".ManagerDataBase::FILETABLE."` 
                    WHERE `".ManagerDataBase::FILETABLE_OWNER."` = '$owner' ;
                ";
                $query = mysqli_query($contact_handle,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $fileid = 0 ;
                        while($row = mysqli_fetch_array($query)){
                            $fileid = $row[0];
                        } 
                        return $fileid ;
                    }else{
                        return false ;
                    }
                }else{
                    return self::ErrorLog($contact_handle->error);
                }
            }else{
                return self::ErrorLog($contact_handle);
            }
        }


        // manager viewe in database  
        /**
         * insert new viewer to file in data base  
         * @param    int    $fileID   : file id 
         * @param    int    $userID :  user id 
         * @return   bool   true if insert new user  | Exception if found any error 
         */
        public static function insertViewToDataBase($fileID ,$userID){
            $contact_handle = ManagerDataBase::connectDataBase() ;
            $result  = "" ;
            if($contact_handle){
                $sql = "INSERT INTO `".ManagerDataBase::VIEWTABLE."`
                        VALUES('$fileID' ,'$userID')  " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $result = true ; 
                    }else {
                        $result = self::ErrorLog(" ERROR WHEN INSERT : not found this user ") ;
                    }
                }else{
                    $result = self::ErrorLog("ERROR IN QUERY :".$contact_handle->error) ;
                }

                
            }else{
                $result = self::ErrorLog($contact_handle) ;
            }
            
            mysqli_close($contact_handle);
            return  $result ;
        
        }
        /**
         * delete  viewer to file in data base  
         * @param    int    $fileID   : file id 
         * @param    int   $userID :  user id 
         * @return   bool   true if delete  user  | Exception if found any error 
         */
        public static function deleteViewInDataBase($fileID ,$userID){
            $contact_handle = ManagerDataBase::connectDataBase() ;
            $result  = "" ;
            if($contact_handle){
                $sql = "DELETE FROM `".ManagerDataBase::VIEWTABLE."`
                        WHERE    `".ManagerDataBase::VIEWTABLE_FILEID."` = '$fileID' AND
                                 `".ManagerDataBase::VIEWTABLE_USERID."` = '$userID' 
                        " ;
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $result = true ; 
                    }else {
                        $result = self::ErrorLog(" ERROR WHEN DELETE : maybe this user not stored befor ") ;
                    }
                }else{
                $result = self::ErrorLog("ERROR IN QUERY :".$contact_handle->error) ;
                }

                
            }else{
                $result = self::ErrorLog($contact_handle) ;
            }
            
            mysqli_close($contact_handle);
            return  $result ;
        }


        /**
         * @todo   get id user can watch and dwonload file 
         * @param       int                     $fileID       : file id 
         * @return      array|null|Excption     : array of users id | null if not found | Excption object if somtheng wrong 
         * 
         * 
         */    
        public static function  getListOfView($fileID){
            $contact_handle = ManagerDataBase::connectDataBase() ;
            $result  = "" ;
            if($contact_handle){
                $sql = "SELECT `".ManagerDataBase::VIEWTABLE_USERID."` 
                        FROM `".ManagerDataBase::VIEWTABLE ."`
                        WHERE    `".ManagerDataBase::VIEWTABLE_FILEID."` = '$fileID' ";
                $query = mysqli_query($contact_handle ,$sql);
                if($query){
                    $list = array();
                    if(mysqli_affected_rows($contact_handle)>0){
                        while($row = mysqli_fetch_array($query)){
                            array_push($list , $row[0]);
                        }
                        $result = $list ;
                    }else{
                        $result = null ; 
                    }
                }else{
                $result = self::ErrorLog("ERROR IN QUERY :".$contact_handle->error) ;
                }

                
            }else{
                $result = self::ErrorLog($contact_handle) ;
            }
            
            mysqli_close($contact_handle);
            return  $result ;
        }



        

        /**
         * function return Exception with message error 
         * @param String  : Error Message  
         * @return Excption : Exception Object with Error Message  
         */
        protected static function ErrorLog($msg){
            return throw new Exception($msg);
        }
        
        // not used 
        /**
         * update children file path 
         * @param Integer  : parent file id 
         * @param String  :  new Path file 
         * 
         */
        public static function updateChildrenFilePath($parentID , $newPath){
            $contact_handle = ManagerDataBase::connectDataBase(); 
            if($contact_handle){
                $sql = "UPDATE `".ManagerDataBase::FILETABLE."` 
                        SET `".ManagerDataBase::FILETABLE_PARENTFILE."` = '$newPath' 
                        WHERE `".ManagerDataBase::FILETABLE_FILEID."` IN (
                            SELECT `".ManagerDataBase::FILETABLE_FILEID."` 
                            FROM `".ManagerDataBase::FILETABLE."` 
                            WHERE `".ManagerDataBase::FILETABLE_PARENTFILE."`  = '$parentID'
                        ); ";
                $query = mysqli_query($contact_handle , $sql) ;
                if($query){
                    return true ;
                }else{
                    return self::ErrorLog("Error message: %s\n", $contact_handle->error );
                }
            }else{
                return FMDB::ErrorLog($contact_handle);
            }
        }

        /**
         * update parent file in DataBase 
         * @param  file  $souresFile   : file need update parent 
         * @param  file $destFile       : file new Parent 
         * @return bool|Excption : true if update done | Excption if found any Error 
         */
        public static function updateParentFile($souresFile , $destFile){
            $souresFileID  =   $souresFile->getFileID();
            $destFileID    =   $destFile->getFileID();
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql = "UPDATE  `".ManagerDataBase::FILETABLE."`
                        SET  `".ManagerDataBase::FILETABLE_PARENTFILE."` = '$destFileID'
                    WHERE `".ManagerDataBase::FILETABLE_FILEID."` = '$souresFileID' ;
                ";
                $query = mysqli_query($contact_handle,$sql);
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0) return true ; 
                }else{
                    return self::ErrorLog("ERROR IN YOUR QUERY :" .$contact_handle->error);
                }
            }else{
                return self::ErrorLog($contact_handle);
            }
        }

        public static function getListOfTypeFile(){
            $contact_handle = ManagerDataBase::connectDataBase();
            if($contact_handle){
                $sql = "SELECT  `".ManagerDataBase::TYPEFILETABLE_ID."`as 'id' ,
                                    `".ManagerDataBase::TYPEFILETABLE_TYPE."` as 'name'
                                    FROM `".ManagerDataBase::TYPYFILETABLE."`
                                    " ;
                $query = mysqli_query($contact_handle , $sql );
                if($query){
                    if(mysqli_affected_rows($contact_handle)>0){
                        $list = array() ;
                        while($row =   mysqli_fetch_array($query)){
                            array_push($list , [
                                'id' => $row['id'] ,
                                'name'=> $row['name']
                            ]);
                        }  
                        return $list ;
                    }else{
                        return self::ErrorLog("ERROR NOT FOUND ANY FILE FROM THIS USER") ;
                    }

                }else{
                    return self::ErrorLog("ERROR IN YOUR QUERY : " .$contact_handle->error);
                }
            }else{
                return self::ErrorLog( $contact_handle) ;
            }
        }

    
        
    
    }
}

?>