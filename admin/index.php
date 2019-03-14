<?php
require "../config.php";

if (!$_SESSION['connected']) {
    Http::redirect('//localhost/php/Restaurant');
}

if ($_SESSION['user']['id'] != 1) {
    Http::redirect('//localhost/php/Restaurant');
}

$controllerName = "ReservationsController";

if (!empty($_GET['controller']) && strlen($_GET['controller']) < 25) {
    $controllerName = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_SPECIAL_CHARS);
}

$method = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$method) {
    $method = "index";
}

require "../libraries/controllers/$controllerName.php";

$controller = new $controllerName();
$controller->$method("admin");

?>