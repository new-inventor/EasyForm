<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentTypeException;

interface FieldInterface extends FormObjectInterface
{
    /**
     * @return array|string|null
     */
    public function getValue();

    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setValue($value);
}