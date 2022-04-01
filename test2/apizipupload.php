<?php 
$path = "./mmj.zip" ;
echo "<pre>" ;
var_dump($_FILES);
// $f  = json_decode($_POST['folderzip']);
// var_dump($f);
echo $_POST['foldername'] ;
echo "</pre>";
foreach ($_FILES as $key => $value) {
    move_uploaded_file($_FILES[$key]['tmp_name'], $path);
    $zip = new ZipArchive();
    if($zip->open($path) === true){
    $zip->extractTo("f1/");
    $zip->close();
    //   delete zip file
    unlink($path);
    }
    return true ;
}
?>