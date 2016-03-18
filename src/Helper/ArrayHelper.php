<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 17:40
 */

namespace NewInventor\EasyForm\Helper;

use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;

class ArrayHelper
{
    /**
     * @param array $elements
     * @param array $types
     * @return bool
     */
    public static function isValidElementsTypes(array $elements, array $types = [])
    {
        if (empty($types)) {
            return true;
        }
        $res = true;
        foreach ($elements as $el) {
            $res = $res && ObjectHelper::is($el, $types);
        }

        return true;
    }


    public static function get(array $elements, $route, $default = null)
    {
        if (!ObjectHelper::is($route, [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::INT])) {
            throw new ArgumentTypeException('route', [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::INT], $route);
        }

        if (is_array($route)) {
            return self::getByRoute($elements, $route, $default);
        }

        return self::getByIndex($elements, $route, $default);
    }

    /**
     * @param array $elements
     * @param string[]|int[] $route
     * @param mixed|null $default
     * @return mixed
     * @throws ArgumentException
     */
    public static function getByRoute(array $elements, array $route = [], $default = null)
    {
        if (!self::isValidElementsTypes($route, [ObjectHelper::STRING, ObjectHelper::INT])) {
            throw new ArgumentException('Елементы должны быть или целыми числами или строками.', 'route');
        }

        foreach ($route as $levelName) {
            if (!isset($elements[$levelName])) {
                return $default;
            }
            $elements = $elements[$levelName];
        }

        return $elements;
    }

    /**
     * @param array $elements
     * @param string|int $name
     * @param null $default
     * @return null
     * @throws ArgumentTypeException
     */
    public static function getByIndex(array $elements, $name, $default = null)
    {
        if (!ObjectHelper::is($name, [ObjectHelper::STRING, ObjectHelper::INT])) {
            throw new ArgumentTypeException('name', [ObjectHelper::STRING, ObjectHelper::INT], $name);
        }

        if (isset($elements[$name])) {
            return $elements[$name];
        }

        return $default;
    }


    public static function set(array $elements, $route, $value)
    {
        if (!ObjectHelper::is($route, [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::INT])) {
            throw new ArgumentTypeException('route', [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::INT], $route);
        }

        if(is_array($route)) {
            $resArrayRoute = '';
            foreach ($route as $levelName) {
                $resArrayRoute .= '[' . (is_int($levelName) ? $levelName : "'$levelName'") . ']';
            }
            eval('$elements' . $resArrayRoute . ' = $value;');
        }else{
            $elements[$route] = $value;
        }

        return $elements;
    }
}