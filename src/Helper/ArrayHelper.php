<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 17:40
 */

namespace NewInventor\EasyForm\Helper;

class ArrayHelper
{
    public static function isValidElementsTypes($elements, array $types = [])
    {
        if(empty($types)){
            return true;
        }
        $res = true;
        foreach($elements as $el){
            $res = $res && ObjectHelper::isValidElementTypes($el, $types);
        }

        return true;
    }
}