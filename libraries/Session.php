<?php 

if (empty($_SESSION['flashes'])) {
    $_SESSION['flashes'] = ['errors' => [], 'successes' => []];
}
if (empty($_SESSION['connected'])) {
    $_SESSION['connected'] = false;
}
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (empty($_SESSION['ordering'])) {
    $_SESSION['ordering'] = false;
}
if (empty($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}

class Session
{
    public static function connect($user)
    {
        $_SESSION['connected'] = true;
        $_SESSION['user'] = $user;
    }

    public static function disconnect()
    {
        $_SESSION['connected'] = false;
        $_SESSION['user'] = null;
    }

    public static function addError(string $flash)
    {
        $_SESSION['flashes']['errors'][] .= $flash;
    }

    public static function addSuccess(string $flash)
    {
        $_SESSION['flashes']['successes'][] .= $flash;
    }

    public static function displayErrors()
    {
        foreach ($_SESSION['flashes']['errors'] as $error) {
            echo $error . "<br>";
        }
        $_SESSION['flashes']['errors'] = [];
    }

    public static function displaySuccesses()
    {
        foreach ($_SESSION['flashes']['successes'] as $success) {
            echo $success . "<br>";
        }
        $_SESSION['flashes']['successes'] = [];
    }

    public static function previousLocation()
    {
        $_SESSION['previousLocation'] = $_SERVER['HTTP_REFERER'];
    }
}




?>