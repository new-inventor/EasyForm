<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\EasyForm\Validator\Validators;

use NewInventor\EasyForm\Validator\AbstractValidator;
use NewInventor\EasyForm\Validator\ValidatorInterface;

class StringValidator extends AbstractValidator implements ValidatorInterface
{
    protected $length;
    protected $minLength;
    protected $maxLength;

    protected $lengthMessage;
    protected $minLengthMessage;
    protected $maxLengthMessage;

    public function isValid($value)
    {
        return true;
    }

    public function getError()
    {
        return [];
    }
}