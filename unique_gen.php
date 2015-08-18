<?php
    function unique_generator($lot_size = 15){
        $alpha_s = range('a', 'z');
        $alpha_l = range('A', 'Z');
        $numbers = range(0, 9);
        $char = array_merge($alpha_l,$alpha_s,$numbers);
        $unique = "";
        for($i = 0; $i < $lot_size; $i++){
            $key = rand(0,count($char)-1);
            $unique .= $char[$key];
        }
        return $unique;
    }
?>