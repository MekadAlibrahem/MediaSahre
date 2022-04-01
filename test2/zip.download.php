<?php
// $files = array('./pdo.php');
// $path_zip_file = './f1/tempzip/';
// $zipname = 'test2.zip';
// $zip = new ZipArchive;
// $zip->open($path_zip_file.$zipname, ZipArchive::CREATE);
// foreach ($files as $file) {
//   $zip->addFile($file);
// }
// $zip->close();

///Then download the zipped file.
// header('Content-Type: application/zip');
// header('Content-disposition: attachment; filename='.$zipname);
// header('Content-Length: ' . filesize($zipname));
// readfile($zipname);

// $zip = new ZipArchive;
// if ($zip->open("f1/tempzip/test.zip") === true) {
//     $zip->extractTo('f2/');
//     $zip->close();
// }
// echo intval(microtime() )* pow(10 , 10);
// echo "<br>" ;
// echo time();
 function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
            echo $_SERVER['HTTP_ORIGIN'];
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
    
    echo "You have CORS!";
}
cors();
?>