<?php 
namespace MediaShare ;

use Exception;
use PDO;
  class ManagerDataBase {
    const USERNAME  = "root" ;
    const HOSTNAME  ="localhost" ;
    const PASSWORD  = "" ;
    const DATABASE  = "test" ;
    // Table name in data base 
    const USERSTABLE    =  "user_table" ;
    const FILETABLE     =  "files_table" ;
    const TYPYFILETABLE =  "type_file_table" ;
    const TYPEUSERTABLE =  "" ;
    const VIEWTABLE     = "view_table" ;
    const BANKTABLE     = "bank_account_table" ;

    // columns Name in User Table in data Base
    const USERSTABLE_USERID = "user_id" ;
    const USERSTABLE_USERNAME = "name" ;
    const USERSTABLE_EMAIL = "email" ;
    const USERSTABLE_PASSWORD = "password"  ;
    const USERSTABLE_TYPEUSER = "type_account_id" ;
    const USERSTABLE_STORAG   ="space";
    const USERSTABLE_LASTLOGIN = "lastlogin";

    //columns name is File tanle in database  
    const FILETABLE_FILEID    = "file_id" ;
    const FILETABLE_FILENAME  = "file_name" ;
    const FILETABLE_OWNER     = "user_id" ;
    const FILETABLE_PARENTFILE = "parent_file_id" ;
    const FILETABLE_TYPEFILE = "type_file_id" ;
    const FILETABLE_PATHFILE = "path" ;
    //columns name in view table in database  
    const VIEWTABLE_FILEID  =    "file_id" ;
    const VIEWTABLE_USERID  =    "user_id" ;
    //columns name in bank account table in database 
    const BANKTABLE_ID       = "id" ;
    const BANKTABLE_ACCOUNT  = "account" ;
    const BANKTABLE_PASSWORD = "passowrd" ;
    const BANKTABLE_COUNT    = "count";
    // columns name in type file table
    const TYPEFILETABLE_ID  = "type_file_id" ;
    const TYPEFILETABLE_TYPE = "type" ;

    //const 
    const ROOTPATH = "C://xampp/htdocs/MediaShare/public/test" ;
    const TEMPFOLDER = "C://xampp/htdocs/mediashare/public/temp/";
    const FOLDERDOWNLOAD = "C://xampp/htdocs/MediaShare/php/api/download/" ;
    const TEMPFOLDERSERVER = "http://localhost/MediaShare/public/temp/" ;
    const PATHDOWNLOAD = "http://localhost/MediaShare/public/html/downloadPage.php?" ;

    public static function connectDataBase(){
        $mysqli  = mysqli_connect(self::HOSTNAME , self::USERNAME , self::PASSWORD , self::DATABASE);
        if($mysqli->connect_errno) {
            return "Connect failed: %s\n" .$mysqli->connect_error;
        }
        if($mysqli){
            mysqli_set_charset($mysqli , "UTF8") ; 
            return $mysqli ; 
        }
    } 
  }
?>