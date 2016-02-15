<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 16:26
 */

namespace NewInventor\EasyForm\Helper;

class ObjectHelper
{
    const BOOL = 'boolean';
    const INT = 'integer';
    const STRING = 'string';
    const FLOAT = 'float';
    const ARR = 'array';
    const OBJ = 'object';
    const RESOURCE = 'resource';
    const NULL = 'null';

    public static function isValidArgumentType($value, $expectedTypes)
    {
        $res = true;
        foreach($expectedTypes as $type){
            $res = $res && (gettype($value) == $type);
        }

        return $res;
    }

    public static function isValidElementTypes($el, $expectedTypes)
    {
        $res = true;
        foreach($expectedTypes as $type){
            $res = $res && is_a($el, $type);
        }

        return $res;
    }
}