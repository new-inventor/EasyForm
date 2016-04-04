<?php

namespace NewInventor\Form\Renderer;

use NewInventor\Abstractions\Interfaces\ObjectInterface;

interface RendererInterface
{
    /**
     * @param ObjectInterface $handler
     * 
     * @return string
     */
    public function render(ObjectInterface $handler);
}