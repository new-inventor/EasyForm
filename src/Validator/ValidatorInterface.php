<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:48
 */

namespace NewInventor\Form\Validator;

use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

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