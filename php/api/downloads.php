<?php

use MediaShare\ManagerDataBase;
$file =  $_GET['f'];
$quoted = sprintf('"%s"', addcslashes(basename($file), '"\\'));
$size   = filesize($file);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $quoted); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile( ManagerDataBase::TEMPFOLDER . $quoted , true );




// include_once "../class.ManagerDataBase.php";
// $filezipName  = $_GET['f'];
// header('Content-Type: application/zip');
// header('Content-disposition: attachment; filename='.$filezipName);
// header('Content-Length: ' . filesize($filezipName));
// readfile(ManagerDataBase::TEMPFOLDER . $filezipName , true);
// unlink(ManagerDataBase::TEMPFOLDER.$filezipName);


?>