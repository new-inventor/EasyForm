<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Renderer\RenderableInterface;
use NewInventor\EasyForm\Validator\ValidatableInterface;
use NewInventor\EasyForm\Validator\ValidatorInterface;

interface FieldInterface extends FormObjectInterface, RenderableInterface, ValidatableInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setValue($value);

    /**
     * @return $this
     */
    public function clear();

    /**
     * @param \Closure|string|ValidatorInterface $validator
     * @param array $options
     * @return $this
     */
    public function validator($validator, array $options = []);

    /**
     * @return bool
     */
    public function isRepeatable();
}