<?php

use MediaShare\Users\Visitor;

session_start();
session_destroy();
include_once "../class.visitor.php" ;
echo  json_encode(array( "status" => true  , "href" => Visitor::PUBLICPATH."/index.php" ));

?>