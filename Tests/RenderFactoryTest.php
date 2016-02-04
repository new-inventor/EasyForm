<?php
namespace NewInventor\EasyForm\Tests;

use \NewInventor\EasyForm\Renderer\RenderFactory;

class RenderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $factory = new RenderFactory();
        $renderer = $factory->getRenderrer();

        $this->assertInstanceOf('\NewInventor\EasyForm\Renderer\RenderFactory', get_class($renderer));
    }
}