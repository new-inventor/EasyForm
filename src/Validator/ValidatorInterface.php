<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:48
 */

namespace NewInventor\EasyForm\Validator;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Interfaces\FieldInterface;

interface ValidatorInterface
{
    /**
     * @param string|array|null $value
     * @return mixed
     */
    public function isValid($value);

    /**
     * @return string|null
     */
    public function getError();

    /**
     * @param array $options
     * @throws ArgumentTypeException
     */
    public function setOptions(array $options);

    /**
     * @param \Closure $customValidateMethod
     */
    public function setCustomValidateMethod(\Closure $customValidateMethod);

    /**
     * @param FieldInterface $field
     */
    public function field(FieldInterface $field);
}