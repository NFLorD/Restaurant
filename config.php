<?php 
session_start();

require "libraries/Cart.php";
require "libraries/Http.php";
require "libraries/Session.php";
require "libraries/Sanitize.php";

// FILTER GET
if (isset($_GET)) {
    $_GET = Sanitize::get();
}

// FILTER POST
if (isset($_POST)) {
    $_POST = Sanitize::post();
}

// COOKIE FOR LOG-IN
if (isset($_COOKIE['user_id'])) {
    $_SESSION['user']['id'] = $_COOKIE['user_id'];
    $_SESSION['user']['firstname'] = $_COOKIE['user_firstname'];
    $_SESSION['user']['lastname'] = $_COOKIE['user_lastname'];
    $_SESSION['user']['phonenumber'] = $_COOKIE['user_phonenumber'];
    $_SESSION['user']['email'] = $_COOKIE['user_email'];
    $_SESSION['connected'] = true;
}

// FLASHES
if (empty($_SESSION['flashes'])) {
    $_SESSION['flashes'] = ['errors' => [], 'successes' => []];
}

// CONNECTED
if (empty($_SESSION['connected'])) {
    $_SESSION['connected'] = false;
}

// CART
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ORDERING ?
if (empty($_SESSION['ordering'])) {
    $_SESSION['ordering'] = false;
}

// ORDER TOTAL
if (empty($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}

const ROOT = __DIR__;
const WEB_ROOT = "//localhost/php/Restaurant";

?>