<?php
namespace MediaShare ;

use Exception;
use mysqli;
use Throwable;

require "class.ManagerDataBase.php" ;

class TestFile {
    public $fileName ; 
    public $fileID ; 
    public $owner ;
    public $path  ; 
    public $parentFile ;
    public $type ; 
    private  const FILE_NOT_STORED = -1 ;
    private const PUBLIC_FILE = 1 ;
    private const PROTECTED_FILE  = 2 ;
    private const PRIVATE_FILE  =  3 ;

    // construct methods  
    public function __construct(){
            // dont delet this method  
    }

    
    public static  function CreatObject( $fileid  ,  $fileName = null ,$owner = null   , $parentFile = null  , $type = self::PUBLIC_FILE  ){
    
        $file =  new self();
        $file->setFileID($fileid) ;
        if($fileid == self::FILE_NOT_STORED){
            $file =  self::constructNewObject($file ,  $fileName  ,$owner  , $parentFile  , $type );
        }else{
            $file  =  self::constructFileStored($file);            
        }
        return $file ;   
    }
    private  static function constructFileStored( $file ){
        $contact_handle = ManagerDataBase::connectDataBase();
        $result  = "" ;
        if($contact_handle){
            $fileinfo = self::getfileDetells($file->fileID ,$contact_handle);
            if(is_array($fileinfo)){
                $file->setFileName($fileinfo['name']);     
                $file->setOwner($fileinfo['owner']);
                $file->setparentFile($fileinfo['parent']);
                $file->setType($fileinfo['type']);
                $file->setPath($fileinfo['path']);    
                $result =  $file ;
            }else{
                $result =  $file ;
            }

        }
        else{
            $result =  throw new Exception($contact_handle);
        }
        mysqli_close($contact_handle);
        return  $result ;
         
        
    }
   
    private static function constructNewObject( $file  ,  $fileName  ,$owner , $parentFile  , $type ){
        $file->setFileName($fileName);     
        $file->setOwner($owner);
        $file->setparentFile($parentFile);
        $file->setType($type);
        if($file->parentFile != null){
            
                $parent = TestFile::CreatObject($parentFile);
                if(!$parent instanceof TestFile){
                    
                    return  throw new Exception("parent File not Found ") ;
                }
            
            $file->setPath($parent->getPath()."/".$fileName);
        }else{
            $file->setPath("/".$fileName);
        }
        
        return $file ;
    }
    
    private static function getfileDetells($fileid , $contact_handle){
        $sql_getFile = "SELECT 
            ".ManagerDataBase::FILENAME." as 'name',
            ".ManagerDataBase::OWNER." as 'owner',
            ".ManagerDataBase::PARENTFILE." as 'parent',
            ".ManagerDataBase::TYPEFILE." as 'type',
            ".ManagerDataBase::PATHFILE." as 'path'
         FROM  `".ManagerDataBase::FILETABLE."`  
                        WHERE  `".ManagerDataBase::FILEID."` = $fileid " ;
        $file = mysqli_query($contact_handle , $sql_getFile);
        if($file){
            if(mysqli_affected_rows($contact_handle)>0){
                $file = mysqli_fetch_array($file);
                return $file ;
            }else{
                return throw new Exception("Error message : file not  found in database") ; 
            }
        }else{
            return   throw new  Exception("Error message: %s\n", $contact_handle->error  );
        }
        
    }
     //set method
     public function setFileID($id){ $this->fileID = $id ;}
     public function setFileName($newName){  $this->fileName = $newName ; }
     public function setPath($newPathFile){$this->path = $newPathFile ; }
     public function setparentFile($parentFileID ) { $this->parentFile = $parentFileID ; }
     public function setOwner($ownerID ) {$this->owner = $ownerID ;}
     public function setType($type){ $this->type = $type  ;}
 
     // get method 
     public function getFileID(){ return $this->fileID ;}
     public function getFileName(){ return $this->fileName ; }
     public function getOwner() {return $this->owner ;}
     public function getPath() {return $this->path ; } 
     public function getParentFile() { return $this->parentFile ;  }  
     public function getType(){return $this->type ;}
 
    
     
}
?>