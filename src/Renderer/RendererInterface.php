<?php

namespace NewInventor\EasyForm\Renderer;

interface RendererInterface
{
    public function render($context);
    public function toString($context);
}