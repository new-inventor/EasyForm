<?php
/**
 * User: Ionov George
 * Date: 24.02.2016
 * Time: 9:25
 */

function is_set(&$a, $k=false)
{
    if ($k===false)
        return isset($a);

    if(is_array($a))
        return array_key_exists($k, $a);

    return false;
}


$array = [];


is_set($array['NESTED']['NESTED']);
var_dump($array);