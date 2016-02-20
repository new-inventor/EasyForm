<?php

namespace NewInventor\EasyForm\Renderer;

class RenderFactory implements RenderFactoryInterface
{
    protected static $settings;

    protected static $rendererClassName;

    /**
     * RenderFactory constructor.
     * @param array $settings rendererAlias => rendererClass
     */
    public function __construct(array $settings = [])
    {
        self::$settings = include_once(dirname(__DIR__) . '/config/renderer.php');
        self::$settings = array_merge(self::$settings, $settings);
    }

    public function getRenderer()
    {
        if($this->validRendererExists()){
            $className = $this->getRendererClassName();

            return new $className();
        }

        throw new \Exception("No valid renderer specified");
    }

    protected function validRendererExists()
    {
        if($this->isRendererSet()){
            $className = $this->getRendererClassName();

            return
                isset($className) && !empty($className) &&
                class_exists($className);
        }

        return false;
    }

    protected function isRendererSet()
    {
        return isset(self::$settings['renderer']);
    }

    protected function getRendererClassName()
    {
        return self::$settings['availableRenderers'][self::$settings['renderer']];
    }

}