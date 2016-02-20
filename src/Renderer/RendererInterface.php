<?php

namespace NewInventor\EasyForm\Renderer;


use NewInventor\EasyForm\Interfaces\FormInterface;

interface RendererInterface
{
    public function render(FormInterface $form);
    public function toString(FormInterface $form);
}