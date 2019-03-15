<?php 

class Cart
{
    protected static $cart = [];

    protected static function load()
    {
        if (isset($_SESSION['cart'])) {
            self::$cart = $_SESSION['cart'];
        }
    }

    protected static function save()
    {
        self::$cart = $_SESSION['cart'];
    }

    protected static function get()
    {
        self::load();
        return self::$cart;
    }

    public static function add($dish, $qty)
    {
        self::load();

        $id = $dish['id'];

        if (array_key_exists($id, self::$panier)) {
            self::$cart[$id]['quantity'] += $quantity;
        } else {
            self::$panier[$id] = compact('dish', 'qty');
        }
    }

    public static function remove($dish, $qty)
    {
        self::load();

        $id = $dish['id'];

        if (array_key_exists($id, self::$panier)) {
            self::$cart[$id]['quantity'] -= $quantity;
        } else {
            self::$panier[$id] = compact('dish', 'qty');
        }
    }
}

?>