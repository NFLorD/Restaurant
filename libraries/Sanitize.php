<?php

class Sanitize
{
    static public function post()
    {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    static public function get()
    {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}


?>