<?php

namespace NewInventor\EasyForm\Renderer;

use Prophecy\Exception\Doubler\MethodNotFoundException;

class RenderFactory implements RenderFactoryInterface
{
    protected static $settings;

    /**
     * RenderFactory constructor.
     * @param array $settings rendererAlias => rendererClass
     */
    public function __construct(array $settings = [])
    {
        self::$settings = include_once(dirname(__FILE__) . '/settings.php');

        self::$settings = array_merge(self::$settings, $settings);
    }

    public function getRenderer()
    {

    }

    public function __call($name, $params)
    {
        if (isset(self::$settings[$name])) {
            $className = self::$settings[$name];

            return new $className();
        }

        throw new MethodNotFoundException('Method not found', self::class, $name, $params);
    }
}