<?php
namespace NewInventor\EasyForm\Tests;

use NewInventor\EasyForm\Renderer\RendererInterface;
use NewInventor\EasyForm\Renderer\RenderFactory;

class RenderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRenderer()
    {
//        $factory = new RenderFactory();
//        $renderer = $factory->getRenderer();
//
//        $this->assertTrue('NewInventor\EasyForm\Renderer\Renderers\PHPRenderer' === get_class($renderer));
//
//        return $renderer;
    }

    /**
     * @depends testGetRenderer
     * @param RendererInterface $renderer
     */
    public function testRender($renderer)
    {
//        $this->assertTrue(is_string($renderer->toString([])));
//        $render = $renderer->render([]);
//        $this->assertTrue(is_null($render));
    }
}