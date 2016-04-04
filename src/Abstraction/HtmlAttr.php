<?php
/**
 * User: Ionov George
 * Date: 16.02.2016
 * Time: 10:20
 */

namespace NewInventor\Form\Abstraction\asd;

class HtmlAttr
{
    public static function build($name, $value = ''){
        $builder = new KeyValuePairBuilder('htmlAttribute');

        return $builder->build($name, $value);
    }
}