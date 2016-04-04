<?php

namespace NewInventor\Form\Interfaces;

use NewInventor\Form\Renderer\RenderableInterface;
use NewInventor\Form\Validator\ValidatableInterface;
use NewInventor\Form\Validator\ValidatorInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

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