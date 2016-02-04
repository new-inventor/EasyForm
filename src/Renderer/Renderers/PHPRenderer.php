<?php

namespace NewInventor\EasyForm\Renderer\Renderers;

use NewInventor\EasyForm\Renderer\RendererInterface;

class PHPRenderer implements RendererInterface
{
    public function render($context)
    {
        echo 'render';
    }

    public function toString($context)
    {
        return 'render';
    }
}