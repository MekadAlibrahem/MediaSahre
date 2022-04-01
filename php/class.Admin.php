<?php 
namespace MediaShare\Users ;

include_once "class.User.php" ;
use MediaShare\Users\User ;
use Exception ;

class Admin extends User{
    
    public function __construct(){
        // dont delete this method 
    }


    public static function CreateAdmin($userID){
        try{
            $admin = new self();
            $listinfo = ManagerUsersDB::getUserinfo($userID);
            if(is_array($listinfo)){
                $admin->userID       = $userID ;
                $admin->userName     = $listinfo['userName']; 
                $admin->email        = $listinfo["email"] ;
                $admin->password     = $listinfo['password'];
                $type = ManagerUsersDB::getTypeUserByUserName($admin->getUserName());
                if($type != ManagerUsersDB::ADMIN_USER) return "لا تملك صلاحية للوصل الى هذا الحساب " ;
                else{
                    return $admin ;
                }
               
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function getAllUsers(){
        return   self::getAllUser();
    }
    public static function getCountUser(){
        return self::getCountUserAccount();
    }

    public static function getAllMemoryPaid(){ 
        return self::getAllMemoryUsed();
    }
    //دوال خاصة بإعاددات الموقع 
    public static  function setDefaultMemory($newMemory){
        $setting_file = self::SETTING_PATH."/".self::SETTING_FILE ;
        $settings = json_decode(file_get_contents($setting_file), true);

		if(isset($settings[self::SETTING_FILE_DEFAULT_MEMORY])){
			$settings[self::SETTING_FILE_DEFAULT_MEMORY] = $newMemory;

			file_put_contents($setting_file, json_encode($settings));
		}else{
			throw new Exception("Settings Key ({".self::SETTING_FILE_DEFAULT_MEMORY."}) Doesn't Exists");
		}
    }

    public static function setAllMemory($newMemory){
        $setting_file = self::SETTING_PATH."/".self::SETTING_FILE ;
        $settings = json_decode(file_get_contents($setting_file), true);

		if(isset($settings[self::SETTING_FILE_DEFAULT_MEMORY])){
			$settings[self::SETTING_FILE_ALL_MEMORY] = $newMemory;

			file_put_contents($setting_file, json_encode($settings));
		}else{
			throw new Exception("Settings Key ({".self::SETTING_FILE_ALL_MEMORY."}) Doesn't Exists");
		}
    } 
    public static function setPriceUnitMemory($newprice){
        $setting_file = self::SETTING_PATH."/".self::SETTING_FILE ;
        $settings = json_decode(file_get_contents($setting_file), true);

		if(isset($settings[self::SETTING_FILE_DEFAULT_MEMORY])){
			$settings[self::SETTING_FILE_PRICE_MEMORY] = $newprice;

			file_put_contents($setting_file, json_encode($settings));
		}else{
			throw new Exception("Settings Key ({".self::SETTING_FILE_PRICE_MEMORY."}) Doesn't Exists");
		}
    } 
    public static function getAllMemoryInServer(){
        return self::getAllMemory();
    } 
    public static function getPriceUnitMemory(){
        return self::getPriceMemory();
    }
    public static function getDefaultMemory(){
        return self::getDefultSizeMemory();
    }

    

    

   
    
}

?>