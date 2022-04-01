<?php
require "../php/class.File.php";
use MediaShare\Files\File ;
// Create a directory and file tree

// mkdir('testcopy');
// mkdir('testcopy/one-a');
// touch('testcopy/one-a/testfile');
// mkdir('testcopy/one-b');

// // Add some hidden files for good measure

// touch('testcopy/one-b/.hiddenfile');
// mkdir('testcopy/one-c');
// touch('testcopy/one-c/.hiddenfile');

// // Add some more depth

// mkdir('testcopy/one-c/two-a');
// touch('testcopy/one-c/two-a/testfile');
// mkdir('testcopy/one-d/');

// // Test that symlinks are created properly

// mkdir('testlink');
// touch('testlink/testfile');

//  C://xampp/htdocs/mediashare/public/temp/1648809101_archive/bootstrap.min.js.map-|- C://xampp/htdocs/MediaShare/public/test/user/bootstrap.min.js.map
// $status = File::xcopy('C://xampp/htdocs/MediaShare/public/test/user/bootstrap.min.js.map', 'C://xampp/htdocs/mediashare/public/temp/1648809101_archive/bootstrap.min.js.map');
$if = copy("f1/f11/t2" , "f2/");
 if($if === true){
     echo "done" ; 
 }else{
     echo "error" ;
 }

?>