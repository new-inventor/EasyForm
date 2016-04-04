<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:38
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FormInterface;

trait Children
{
    /**
     * @param FormInterface|BlockInterface $object
     *
     * @return string
     */
    public function children($object)
    {
        return implode('', $object->children()->getAll());
    }
}