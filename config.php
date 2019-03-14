<?php 
session_start();

require "libraries/Http.php";
require "libraries/Session.php";
require "libraries/Sanitize.php";

if(isset($_REQUEST)){
    $_GET = Sanitize::get();
}

const ROOT = __DIR__;
const WEB_ROOT = "//localhost/Restaurant";


?>