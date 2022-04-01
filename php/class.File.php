<?php
namespace MediaShare\Files {
    /**
     *  لازم تراجع دالة الحذف تاكد من التنفيذ تبعها 
     * 
     * 
     * 
     */

    /** 
     *  دوال  الاساسية تم تنفيذها 
    * دالة إنشاء ملف 
    * دالة إنشاء مجلد
    *  دوال التعديل ( الاسم  -  النوع )
    * دالة حذف مجدل او ملف 
    * دالة نسخ 
    * دالة حذف 
    * دوال إدارة المشاهدين لملف (إضافة - حذف -جلب قائمة بهم لملف ما  )
    */
    use Exception;
    use mysqli;
    use SplFileInfo ;
    use DirectoryIterator ;
    use MediaShare\ManagerDataBase ;


    include_once "class.FMDB.php" ;


    class File extends FMDB {
        public $fileName ; 
        public $fileID ; 
        public $owner ;
        public $path  ; 
        public $parentFile ;
        public $type ; 

        public const PUBLIC_FILE = 1 ;
        public const PROTECTED_FILE  = 2 ;
        public const PRIVATE_FILE  =  3 ;

        const BYTE = 1 ;

        // construct methods  
        
        public function __construct(){
                // dont delet this method  
        }  
        /**
         * construct method for create new object File  
         * @param   int            $fileid      : file id   ,  -1 if file not stored in database   
         * @param   string|null    $fileName    : file name   
         * @param   int|null       $owner       : owner id  
         * @param   int|null       $parentFile  : id parent File  
         * @param   int|null       $type        : type of file {1 ,2,3} ;
         * @return  File|Exception              : object file | find any ERROR 
         */
        public static  function CreatObject( $fileid  ,  $fileName = null ,$owner = null   , $parentFile = null  , $type = FILE::PUBLIC_FILE  ){
            $file =  new self();
            $file->setFileID($fileid) ;
            if($fileid == File::FILE_NOT_STORED){
                $file =  File::constructNewObject($file ,  $fileName  ,$owner  , $parentFile  , $type );
            }else{
                $file  =  File::constructFileStored($file);

                        
            }
            return $file ;   
        }

        /**
         * return file oject with file  information  on database  
         * @param File              $file        : file object  
         * @return File|Exception                : file object  with file information | if found any ERROR
         * 
         */
        private  static function constructFileStored(File $file ){
            $fileinfo = FMDB::getFileByID($file->fileID);
            if(is_array($fileinfo)){
                $file->setFileName($fileinfo['name']);     
                $file->setOwner($fileinfo['owner']);
                $file->setparentFile($fileinfo['parent']);
                $file->setType($fileinfo['type']);
                $file->setPath(self::getPathByParent($file));  
                return  $file ;
            }else{
                return $fileinfo;
            } 
        }
        /**
         * return new file object  (file is not stored in database )
         * @param File             $file        : object file   
         * @param   string|null    $fileName    : file name   
         * @param   int|null       $owner       : owner id  
         * @param   int|null       $parentFile  : id parent File  
         * @param   int|null       $type        : type of file {1 ,2,3} ;
         * @return  File|Exception              : object file | find any ERROR 
         */
        private static function constructNewObject( File $file  ,  $fileName  ,$owner , $parentFile  , $type ){
            $file->setFileName($fileName);     
            $file->setOwner($owner);
            $file->setparentFile($parentFile);
            $file->setType($type);
            $file->setPath(self::getPathByParent($file));
            return $file ;
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

    // main method 
        // creat new File 
        /**
         * creat new File  
         * @param   int            $fileid      : file id   ,  -1 if file not stored in database   
         * @param   string|null    $fileName    : file name   
         * @param   int|null       $owner       : owner id  
         * @param   int|null       $type        : type of file {1 ,2,3} ;
         * @param   int|null       $parentFile  : id parent File  
         * @return  bool|Exception              : true |  message error if somsthing wrong 
         */
        public static function newFile( $fileName , $owner  , $type = File::PUBLIC_FILE , $parentId = null  ){
            try{ 
                $file = File::CreatObject(-1 , $fileName , $owner ,$parentId , $type);
                $isCreat = File::create($file);
                return $isCreat;
            }catch(Exception $e) {
                return $e->getMessage();
            }
        }

        // creat new directory 
        /**
         * creat new directory  
         * @param   int            $fileID      : file id   ,  -1 if file not stored in database   
         * @param   string|null    $fileName    : file name   
         * @param   int|null       $owner       : owner id  
         * @param   int|null       $type        : type of file {1 ,2,3} ;
         * @param   int|null       $parentFile  : id parent File  
         * @return  bool|Exception              : true |  message error if somsthing wrong 
         */
        public static function newFolder( $fileName , $owner ,  $type = File::PUBLIC_FILE , $parentId = null   ){
            try{ 
                $file = File::CreatObject(-1 , $fileName , $owner ,$parentId , $type);
                $isCreat = File::create($file , true);
                return $isCreat ;
            }catch(Exception $e) {
                return $e->getMessage();
            }
        }
        
        // rename file  
        /**
         * method rename File 
         * @param       int            $fileID      : file id   ,  -1 if file not stored in database   
         * @param       string         $newName     :  new file name   
         * @return      true|Exception              : true if rename done  |message error if somsthing wrong
         */

        public static function rename($fileID  , $newName , $owner){
            try{
                $file = File::CreatObject($fileID);
                if($owner != $file->getOwner()){
                    return "لاتملك الصلاحية لتعديل على الملف " ;
                }else{
                    $isedit = $file->editName($newName);
                    if($isedit){
                        return true ;
                    } else{
                        return  "ERORR :" ;
                    }
                }
            }catch(Exception $e){
                return $e->getMessage();
            }

        }

        // delete File  
        /**
         * method rename File 
         * @param       int            $fileID       : file id 
         * @return      true|Exception               : true if delete done  | message error if somsthing wrong
         */
        public static function delete($fileID){
            try{
                $file = File::CreatObject($fileID) ;
                $isDelete = File::deleteFile($file);  
                if($isDelete) return true ;    
            }catch(Exception $e){
                return $e->getMessage();
            }
    
        }


        // retype
        /**
         * method retype file 
         * @param       int            $fileID       : file id 
         * @param       string         $newType     :  new file tyoe   
         * @return      true|Exception               : true if delete done  | message error if somsthing wrong
         */
        public static function retype($fileID , $newType , $owner ){
            try {
                $file = File::CreatObject($fileID);
                if($owner != $file->getOwner()){
                    return "لاتملك الصلاحية لتعديل على الملف " ;
                }else{
                   
                    $isretype =  $file->editType($newType);
                    if($isretype === true ){
                        return true ;
                    }else{
                        return $isretype ;
                    }  
                } 
            }catch (Exception $th) {
            return $th->getMessage();
            }
            
        }
        //copy 
        /**
         * method copy file or floder and all content 
         * @param   int             $sourceFileID     : source id file or folder
         * @param   int             $destFileID       : dest id file or folder 
         * @return  bool|Excption                     : true if copy done | message error if somsthing wrong
         */
        public static function copy($sourceFileID ,$destFileID ){
            try{
                $sourceFile = File::CreatObject($sourceFileID);
                $destFile   = File::CreatObject($destFileID);
                $source = ManagerDataBase::ROOTPATH . $sourceFile->getPath() . $sourceFile->getFileName();
            
                $dest   = ManagerDataBase::ROOTPATH . $destFile->getPath() . $destFile->getFileName()  . "/".$sourceFile->getFileName();
            
                $isCopy = self::xcopy($source , $dest);
                if($isCopy){
                self::insertFolderInDataBase($dest , $destFileID);
                return true ;
                }
                return false ;

            }catch(Exception $e){
                return $e->getMessage();
            }
        
        }

        //move file (cut)
        /**
         * method change file path (move file to another location)
         * @param   int             $sourceFileID    : source id file or folder
         * @param   int             $destFileID      : dest id file or folder 
         * @return  bool|Excption                    : true if copy done | message error if somsthing wrong
         */
        public static function move($sourceFileID ,$destFileID){
            try{
                $isCopy = self::copy($sourceFileID , $destFileID);
                if($isCopy === true){
                    $isDelete  = self::delete($sourceFileID); 
                    if($isDelete){
                        return true ;
                    }else{
                        return false ;
                    }
                }else{
                    return $isCopy ;
                }
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    // manager viewe  
        /**
         * @todo  add new view to file 
         * @param   int             $fileID   : file id 
         * @param   int             $userID     : id user  we wanted him to view
         * @return  bool|Excption   : true if done | error meesage if somthing wrong     
         */
        public static function addView($fileID ,  $userID, $owner ){
            try{
                // when creat object file we check if file id is courrect 
                $file = File::CreatObject($fileID);
                if($file->getOwner() != $owner) { return "لا تملك الصلاحيىة لتعديل هذا الملف " ;}
                $listviewID = File::getListViewToFile($fileID , $owner);
                $isFiendView = false ;
                if(!empty($listviewID) && is_array($listviewID) ){
                    $isFiendView  = self::checkIfViewInserted($listviewID , $userID);
                }
                if($isFiendView === true) return  "هذا المستخدم مضاف سابقا "  ;
                $isInsert = FMDB::insertViewToDataBase($fileID , $userID);
                return $isInsert ;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        public static function checkIfViewInserted($listView ,$viewID){
            foreach ($listView as $id) {
                if($id == $viewID) return true ;
            }
            return false ;
        }
        /**
         * @todo  delete  view to file 
         * @param   int             $fileID   : file id 
         * @param   int             $viewID     : id user  we delete him to view
         * @param   int             $owner      : id user is onwer this file 
         * @return  bool|Excption   : true if done | error meesage if somthing wrong     
         */

        public static function deleteView($fileID , $viewID ,  $owner){
            try{
                // when creat object file we check if file id is courrect 
                $file = File::CreatObject($fileID);
                if($file->getOwner() != $owner) { return "لا تملك الصلاحيىة لتعديل هذا الملف " ;}
                $isInsert = FMDB::deleteViewInDataBase($fileID , $viewID);
                return $isInsert ;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        /**
         * @todo  get list of view to file 
         * @param   int             $fileID   : file id 
         * @return  bool|Excption   : true if done | error meesage if somthing wrong     
         */

        public static function getListViewToFile($fileID , $owner){
            try{
                // when creat object file we check if file id is courrect 
                $file = File::CreatObject($fileID);
                if($file->getOwner() != $owner) { return "لا تملك الصلاحيىة لتعديل هذا الملف " ;}
                $listView = FMDB::getListOfView($fileID);
                return $listView ;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }




    // internla method 
        /**
         * create new file 
         * @param File : File object 
         * @param Boolean : false is File  , true if directory 
         * 
         * @return Boolean|Exception : true if done | if found any error 
         * 
         */
        private  static function create(File $file , $isDir = false){
            $fullPath = ManagerDataBase::ROOTPATH."/".$file->getPath()."/".$file->getFileName() ;
            if(!file_exists($fullPath)){
                $isInsertFileToDataBase = FMDB::insertFileToDataBase($file);
                if($isInsertFileToDataBase == true){
                    try{
                        if($isDir==true){
                            mkdir($fullPath);
                        }else{
                            touch($fullPath);
                        }
                        return true ;
                    }catch(Exception $th){
                        return $th ;
                    }    
                }else{
                    return $isInsertFileToDataBase ;
                }
            }else{
                return File::ErrorLog("this file is exists befor ") ;
            }

            
        
        }


        /**
         * get list File Children 
         * @param Integer : parent ID 
         * @return ArrayFiles|exception : return array of File Objects | error message
         */
        private static function getListFileByParent($parentID){
            $listID = FMDB::getListChildrenID($parentID);
            $files = array();
            if(is_array($listID)){
                foreach ($listID as $id) {
                    array_push($files , File::CreatObject($id));
                }
                return $files ;
            }else{
                return $listID ;
            }
        }
        private static function getPathByParent(File $childFile){
            $path  = "/" ;
            $parentTree = array();
            $parentID = $childFile->getParentFile();
            while($parentID != null){
                $parentFile = File::CreatObject($parentID);
                array_unshift($parentTree , $parentFile->getFileName() ) ;
                $parentID = $parentFile->getParentFile();
            }
            
            foreach($parentTree as $parent){
                $path .=$parent."/" ;
            }
            return $path ;
        }
        

        

        
    //edit files 
    // edit file name  
        /**
         * edit file name  
         * @param   string           $newFIleName   : new file name   
         * @return  true|Exception                  : true if done | if found any error 
         */
        public  function editName( $newFileName){
            if($this->getFileID() == -1 ) return self::ErrorLog("this file not stored yet");
            if(file_exists($this->getPath()."/".$newFileName)) return self::ErrorLog("this file is exists befor");
            $isUpdate  = FMDB::updateFileName($this,$newFileName);
            if($isUpdate === true){
                $isrename = $this->renameFile($newFileName);
                if($isrename === true){
                    $this->setFileName($newFileName) ;
                    return true ;
                }
                return $isrename ;
            }
            return $isUpdate ; 
        }
        /** 
         * method get full path to file and change his name  
         * @param    int                $newFileName    : new file name 
         * @return   true|Exception                     : true if rename done | Excption object if somsthig wrong 
         */    
        private  function renameFile($newFileName){
            try {
                $oldPath = ManagerDataBase::ROOTPATH.$this->getPath()."/".$this->getFileName() ;
                $newPath = ManagerDataBase::ROOTPATH.$this->getPath()."/". $newFileName ;
                rename($oldPath , $newPath );
                return true ;
            } catch (Exception $th) {
                return $th ;
            }
        }

        private function editType($type){
            if($this->getFileID() == -1 ) return self::ErrorLog("this file not stored yet");
            if($type == $this->getType()) return true ;
            $isUpdate = FMDB::updateFileType($this->getFileID() , $type);
            if($isUpdate){
                $this->setType($type);
                return true ;
            }else{
                return $isUpdate ;
            }
        }
        /**
         * delete file or folder 
         * @param       File         $file    : file or folder to delete 
         * @return   true|Exception           : true if delete done | Excption object if somsthig wrong 
         */
        private static function deleteFile(File  $file){
            if($file->getFileID() == -1 ) return self::ErrorLog("this file not stored yet");
            $path = ManagerDataBase::ROOTPATH."/".self::getPathByParent($file)."/".$file->getFileName();
            $splfile = new SplFileInfo($path); 
            if($splfile->isFile() ){
                $isDone =  unlink($path) ;
                if($isDone==true) { 
                    $isDelete = self::DeleteFileInDB($file->getFileID()) ;
                    if($isDelete==true) { 
                        return true ;
                    }else {
                        return $isDelete ;
                    }
                }else {
                    return $isDone ;
                }
            }else{
                $isDone =  self::deleteContent($path);
                if($isDone){    
                    $isDelete = self::DeleteFileInDB($file->getFileID()) ;
                    if($isDelete==true) { 
                        rmdir($path);
                        return true ;
                    }else {
                        return $isDelete ;
                    }
                }else{
                    return $isDone ;
                }
            }
            
        }  
        /**
         * delete folder and it's content 
         * @param       string          $path   : path folder  to delete content
         * @return   true|Exception           : true if delete content done | Excption object if somsthig wrong 
         * 
         */
        public static function deleteContent($path){
            try{
            $iterator = new DirectoryIterator($path);
            foreach ( $iterator as $fileinfo ) {
                if($fileinfo->isDot())continue;
                if($fileinfo->isDir()){
                if(self::deleteContent($fileinfo->getPathname()))
                    @rmdir($fileinfo->getPathname());
                }
                if($fileinfo->isFile()){
                @unlink($fileinfo->getPathname());
                }
            }
            } catch ( Exception $e ){
            
            return throw  $e;
            }
            return true;
        }

        /**
         * Copy a file, or recursively copy a folder and its contents
         * @param       string   $source    Source path
         * @param       string   $dest      Destination path
         * @param       int      $permissions New folder creation permissions
         * @return      bool     Returns true on success, false on failure
         */
        public static function xcopy($source, $dest, $permissions = 0755){
            $sourceHash =self::hashDirectory($source);
            // Check for symlinks
            if (is_link($source)) {
                return symlink(readlink($source), $dest);
            }
            // Simple copy for a file
            if (is_file($source)) {
                return copy($source, $dest);
            }
            // Make destination directory
            if (!is_dir($dest)) {
                mkdir($dest, $permissions);
            }
            // Loop through the folder
            $dir = dir($source);
            while (false !== $entry = $dir->read()) {
                // Skip pointers
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                // Deep copy directories
                if($sourceHash != self::hashDirectory($source."/".$entry)){
                    self::xcopy("$source/$entry", "$dest/$entry", $permissions);
                }
            }
            // Clean up
            $dir->close();
            return true;
        }

        // In case of coping a directory inside itself, 
        //there is a need to hash check the directory otherwise and infinite loop of coping is generated

        public static function hashDirectory($directory){
            if (! is_dir($directory)){ return false; }

            $files = array();
            $dir = dir($directory);

            while (false !== ($file = $dir->read())){
                if ($file != '.' and $file != '..') {
                    if (is_dir($directory . '/' . $file)) { $files[] = self::hashDirectory($directory . '/' . $file); }
                    else { $files[] = md5_file($directory . '/' . $file); }
                }
            }

            $dir->close();

            return md5(implode('', $files));
        }

        // Returns an array of files and directories from the directory. 
        /**
         * Returns an array of files and directories from the directory. 
         * @param      string      $pathFile    : path directory   
         * @return     array                    :  list of name file and directories  
         */
        public static function getListFileInDir(String $pathFile){
            $listFilesName = array();
            $files = scandir($pathFile);
            $files = array_diff(scandir($pathFile), array('.', '..'));
            foreach($files as $file){
                array_push($listFilesName ,$file);
            }
            return $listFilesName ;
        }
        /**
         * insert folder and all content in data base 
         * @param   string     $root        : real path in folder
         * @param   int        $parentID    :  id parent folder 
         *   
         */

        public static function insertFolderInDataBase($root , $parentID){
            $parent = File::CreatObject($parentID);
            if(is_dir($root)){
                $list = File::getListFileInDir($root);
                $folder = self::CreatObject(-1 , basename($root) , $parent->getOwner() , $parentID , $parent->getType());
                $isInser  = self::insertFileToDataBase($folder);
                if($isInser){
                    // echo "insert folder : " . $root . " is  done </br>";
                    $folder->setFileID(self::getLastFileInFolder($parentID));
                    foreach ($list as $file) {
                        self::insertFolderInDataBase($root ."/".$file , $folder->getFileID());
                    }
                    
                }else{
                    return self::ErrorLog("ERROR INSERT FOLDER '" .$root."' IN DATABASE") ;
                }
                
            }else if(is_file($root)){
                $file = self::CreatObject(-1 , basename($root) , $parent->getOwner() , $parentID , $parent->getType());
                $isInser  = self::insertFileToDataBase($file);
                // echo "insert file : " . $root . " is  done </br>";
                return true ; 
            } 
            
        }

        /** @todo return size root folder from user
         * @param       int   $owner      :user id  
         * @return      int|string         :size file | error message 
         */
        public static function getRootFileSizeForUser($owner ){
            try{
                $fileID  =  FMDB::getRootFileFromUser($owner);
                
                if($fileID){
                    $file = File::CreatObject($fileID);
                    
                    if($file instanceof File){
                        $fullPath = ManagerDataBase::ROOTPATH . $file->getPath() ."". $file->getFileName();
                        
                        $size = File::getSizeFolder($fullPath);
                        return $size    ;
                    }
                }
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        public static function getSizeFolder($path){
            $size = 0 ; 
            if(is_dir($path)){
                $list = File::getListFileInDir($path);
                if(empty($list)) return 0;
                foreach ($list as $file) {
                    $size += self::getSizeFolder($path ."/".$file );
                }
            }else{
                $size  +=  filesize($path);
                
            }
            return $size;  
        }
        //  بترجع مصفوفة فيها اسم الملف الاب و رقمه لملف محدد
        public static function getPathFileAtArray($file){
            $count = 1 ;
            $path  = "/" ;
            $parentTree = array();
            $parentID = $file->getParentFile();
            while($parentID != null){
                $count++ ;
                $parentFile = File::CreatObject($parentID);
                array_unshift($parentTree , [
                    'name'=>$parentFile->getFileName() ,
                    'id' => $parentFile->getFileID() ,
                    'end' => 0 
                    ] 
                );
                $parentID = $parentFile->getParentFile();
            }
            array_push($parentTree , [
                'name'=>$file->getFileName() ,
                'id' => $file->getFileID() ,
                'end' => 1 
                ] 
            );

            return array('count'=>$count , $parentTree) ;
        }

        // دالة لتحويل بين قيم حجم الملفات 
        public static function formatBytes($bytes, $precision = 2) { 
            $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
        
            $bytes = max($bytes, 0); 
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
            $pow = min($pow, count($units) - 1); 
        
            // Uncomment one of the following alternatives
            $bytes /= pow(1024, $pow);
            // $bytes /= (1 << (10 * $pow)); 
        
            return round($bytes, $precision) . '' . $units[$pow]; 
        } 
        // دالة تعيد معلومات عن كل الملفات و المجلدات في مجدل محدد
        public static function getListFilesInformationInFolder(File $file){
            $listID = File::getListChildrenID($file->getFileID());
            if($listID === false){
                $listFile = array();
            }else{
                $listFile = array();
                foreach ($listID as  $id){
                    $child = File::CreatObject($id);
                    $path = ManagerDataBase::ROOTPATH . $child->getPath(). "/" . $child->getFileName();
                    array_push($listFile , [
                            'id'        => $child->getFileID(),
                            'name'      => $child->getFileName(),
                            'isFile'    => is_file($path ) ? 1 : 0,
                            'type'      => filetype($path),
                            'size'      => File::formatBytes(File::getSizeFolder($path)),
                            'link'      => ManagerDataBase::PATHDOWNLOAD . "f=" . $child->getFileID()
                            ]
                        );
                }
            }
            
            return $listFile ;
        }
        /** @todo دالة تقوم بالتحقق من اذا كان يملك المستخدم صلاحية تحميل ملف 
         *  
         */
        public static function checkValidDownload($fileID , $userID = null){
            try{
                $file  = File::CreatObject($fileID) ;
                if($file->getType() == File::PUBLIC_FILE){
                    return true ;
                }else if($file->getType() ==  File::PRIVATE_FILE  && $file->getOwner() == $userID){
                    return true  ;
                }else if($file->getType() == File::PROTECTED_FILE ){
                    $listViewID = File::getListOfView($fileID);
                    if(is_array($listViewID)){
                        foreach ($listViewID as $id) {
                            if($userID == $id){
                                return true ;
                            }
                        }
                    }
                }
                return  " ليس لديك الصلاحية لتحميل هذا الملف " ;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        
        
        
        // splFileInfo  
        // public static function getRellPath($){

        // }


        /**
         * scandir(path file) :  Returns an array of files and directories from the directory.
         * file_exists(path file) : retunr true if file or directorey is exists  ; 
         * get_object_vars(object) :return array of object proparity ;
         */


        // method not used any more  


            public static function getTreeFile($root , $id){
                $id += 1;
                if(is_dir($root)){
                    $list = File::getListFileInDir($root);
                    echo "<pre>" ;
                    print_r(self::CreatObject(-1 , basename($root) , 8 , 70 ,1));
                    echo "</pre>";
                    
                    foreach ($list as $file) {
                        self::getTreeFile($root ."/".$file , $id);
                    }
                }else{
                    echo "<pre>" ;
                    print_r(self::CreatObject(-1 , basename($root) , 8 , 70 ,1));
                    echo "</pre>";
                }  
            }


        
    


    

   
    
    }
}



?>