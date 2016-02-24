<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentTypeException;

interface FieldInterface extends FormObjectInterface
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
}