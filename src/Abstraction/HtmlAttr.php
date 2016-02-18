<?php
/**
 * User: Ionov George
 * Date: 16.02.2016
 * Time: 10:20
 */

namespace NewInventor\EasyForm\Abstraction;

class HtmlAttr
{
    public static function get($name, $value = ''){
        $builder = new KeyValuePairBuilder('htmlAttribute');

        return $builder->build($name, $value);
    }
}