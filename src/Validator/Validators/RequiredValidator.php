<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\Form\Validator\Validators;

use NewInventor\Form\Validator\AbstractValidator;
use NewInventor\Form\Validator\Exceptions\Required\NotFilledUp;
use NewInventor\Form\Validator\ValidatorInterface;

class RequiredValidator extends AbstractValidator implements ValidatorInterface
{
    public function validateValue($value)
    {
        if(!empty($value) || is_numeric($value)){
            return true;
        }
        throw new NotFilledUp($this->objectName, $this->message);
    }
}