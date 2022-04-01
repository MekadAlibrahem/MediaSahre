<?php

class Archive{
    /**
     * Add files and sub-directories in a folder to zip file.
     * @param string $folder
     * @param ZipArchive $zipFile
     * @param int $exclusiveLength Number of text to be exclusived from the file path.
     */
    private static function folderToZip($folder, &$zipFile, $exclusiveLength) {
      $handle = opendir($folder);
          while (false !== $f = readdir($handle)) {
              if ($f != '.' && $f != '..') {
              $filePath = "$folder/$f";
              // Remove prefix from file path before add to zip.
              $localPath = substr($filePath, $exclusiveLength);
              if (is_file($filePath)) {
                  $zipFile->addFile($filePath, $localPath);
              } elseif (is_dir($filePath)) {
                  // Add sub-directory.
                  $zipFile->addEmptyDir($localPath);
                  self::folderToZip($filePath, $zipFile, $exclusiveLength);
              }
          }
      }
      closedir($handle);
  }

  /**
   * Zip a folder (include itself).
   * Usage:
   *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
   *
   * @param string $sourcePath Path of directory to be zip.
   * @param string $outZipPath Path of output zip file.
   */
  public static function zipDir($sourcePath, $outZipPath){
      $pathInfo = pathInfo($sourcePath);
      $parentPath = $pathInfo['dirname'];
      $dirName = $pathInfo['basename'];
      $z = new ZipArchive();
      $z->open($outZipPath, ZIPARCHIVE::CREATE);
      $z->addEmptyDir($dirName);
      self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
      $z->close();
      return true;
  }

  public  static function unzip($source, $destination) {
      $zip = new ZipArchive;
      if ($zip->open($source) === true) {
          $zip->extractTo($destination);
          $zip->close();
      }
      
  }
  public static function zipFile($sourcePath, $outZipPath){
    $zip = new ZipArchive;
    $zip->open($outZipPath, ZipArchive::CREATE);
    $zip->addFile($sourcePath);
    $zip->close();
    return true ;
  }

  public static function zip($sourcePath,$outZipPath){
      if(is_file($sourcePath)){
           return Archive::zipFile($sourcePath ,$outZipPath);
      }else if(is_dir($sourcePath)){
          return Archive::zipDir($sourcePath ,$outZipPath);
      }
  }
   
}



?>