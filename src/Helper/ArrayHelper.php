<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 17:40
 */

namespace NewInventor\EasyForm\Helper;

use NewInventor\EasyForm\Abstraction\SimpleTypes;
use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;

class ArrayHelper
{
    public static function get(array $elements, $route, $default = null)
    {
        TypeChecker::getInstance()
            ->check($route, [SimpleTypes::STRING, SimpleTypes::ARR, SimpleTypes::INT], 'route')
            ->throwTypeErrorIfNotValid();

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
        TypeChecker::getInstance()
            ->checkArray($route, [SimpleTypes::STRING, SimpleTypes::INT], 'route')
            ->throwCustomErrorIfNotValid('Елементы должны быть или целыми числами или строками.');

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
        TypeChecker::getInstance()
            ->check($name, [SimpleTypes::STRING, SimpleTypes::INT], 'name')
            ->throwTypeErrorIfNotValid();

        if (isset($elements[$name])) {
            return $elements[$name];
        }

        return $default;
    }


    public static function set(array $elements, $route, $value)
    {
        TypeChecker::getInstance()
            ->check($route, [SimpleTypes::STRING, SimpleTypes::ARR, SimpleTypes::INT], 'route')
            ->throwTypeErrorIfNotValid();

        if (is_array($route)) {
            $resArrayRoute = '';
            foreach ($route as $levelName) {
                $resArrayRoute .= '[' . (is_int($levelName) ? $levelName : "'$levelName'") . ']';
            }
            eval('$elements' . $resArrayRoute . ' = $value;');
        } else {
            $elements[$route] = $value;
        }

        return $elements;
    }
}