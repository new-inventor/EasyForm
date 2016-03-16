<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\EasyForm\Validator\Validators;

use NewInventor\EasyForm\Validator\AbstractValidator;
use NewInventor\EasyForm\Validator\ValidatorInterface;

class EmailValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * EmailValidator constructor.
     */
    public function __construct(\Closure $customValidateMethod = null)
    {
        parent::__construct('Неверный формат электронной почты в поле "{f}".', $customValidateMethod);
    }

    public function validateValue($value)
    {
        if(mb_strlen($value) == 0){
            return true;
        }
        return filter_var($value, FILTER_VALIDATE_EMAIL) === $value;
    }
}