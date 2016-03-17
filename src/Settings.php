<?php
/**
 * User: Ionov George
 * Date: 17.03.2016
 * Time: 9:04
 */

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\SingletonTrait;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;

class Settings
{
    use SingletonTrait;
    /** @var array */
    private static $settings;

    protected function __construct()
    {
        self::$settings = include(dirname(__FILE__) . '/config/main.php');
    }

    public function getSetting($name, $default = null)
    {
        if (!ObjectHelper::isValidType($name, [ObjectHelper::STRING])) {
            throw new ArgumentTypeException('name', [ObjectHelper::STRING], $name);
        }

        if (isset($name)) {
            return self::$settings[$name];
        }

        return $default;
    }
}