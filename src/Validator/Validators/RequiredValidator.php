<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\Form\Validator\Validators;

use NewInventor\Form\Validator\AbstractValidator;
use NewInventor\Form\Validator\ValidatorInterface;

class RequiredValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * EmailValidator constructor.
     */
    public function __construct(\Closure $customValidateMethod = null)
    {
        parent::__construct('Поле "{f}" обязательно для заполнения.', $customValidateMethod);
    }
    
    public function validateValue($value)
    {
        return !empty($value) || is_numeric($value);
    }
}