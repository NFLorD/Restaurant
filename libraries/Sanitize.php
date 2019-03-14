<?php

class Sanitize{
    public function post(){ 
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function get(){ 
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}


?>