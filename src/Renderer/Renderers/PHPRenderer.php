<?php

namespace NewInventor\EasyForm\Renderer\Renderers;

use NewInventor\EasyForm\Field;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\FormInterface;
use NewInventor\EasyForm\Renderer\RendererInterface;

class PHPRenderer implements RendererInterface
{
    public function render(FormInterface $form)
    {
        echo $this->toString($form);
    }

    public function toString(FormInterface $form)
    {
        $res = '<form' . $form->attributes()->toArray();
        return 'toString';
    }

    /**
     * @param FieldInterface $field
     */
    public function fieldToString($field)
    {
        if($field instanceof Field\Input){
            $this->inputToString($field);
        }elseif($field instanceof Field\Select){

        }elseif($field instanceof Field\TextArea){

        }
    }

    /**
     * @param FieldInterface $field
     * @return string
     */
    protected function inputToString($field)
    {
        return '<input ' . $field->attributes() . ' />';
    }

    /**
     * @param FieldInterface $field
     * @return string
     */
    protected function selectToString($field)
    {
        return '<select ' . $field->attributes() . ' />';
    }

    public function blockToString($block)
    {

    }
}