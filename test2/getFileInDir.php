<?php 
include "../php/class.File.php";
use MediaShare\Files\File ;
$file = File::CreatObject(103);
$list = File::getPathFileAtArray($file);
echo "<pre>" ;
print_r($list);
echo "</pre>"; 


?>