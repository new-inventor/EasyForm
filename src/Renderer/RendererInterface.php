<?php

namespace NewInventor\EasyForm\Renderer;

use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\FormInterface;

interface RendererInterface
{
    /**
     * @param FormInterface $form
     * @return string
     */
    public function form(FormInterface $form);

    /**
     * @param BlockInterface $block
     * @return string
     */
    public function block(BlockInterface $block);

    /**
     * @param FieldInterface $field
     * @return string
     */
    public function field(FieldInterface $field);
}