<?php

require "config.php";

if (empty($_GET)) {
    $title = "Chez Nico'";
    $template = "home";
    require "templates/template.phtml";
    exit;
}

$controllerName = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_SPECIAL_CHARS);
$method = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_SPECIAL_CHARS);

require "libraries/controllers/$controllerName.php";

// var_dump($_SERVER);
// exit;

$controller = new $controllerName();
$controller->$method();

?>