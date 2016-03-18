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
    const NULL = 'NULL';

    public static function is($value, $expectedTypes)
    {
        if(empty($expectedTypes)){
            return true;
        }
        $res = false;
        foreach($expectedTypes as $type){
            $res = $res || (gettype($value) == $type) || is_a($value, $type);
        }

        return $res;
    }
}