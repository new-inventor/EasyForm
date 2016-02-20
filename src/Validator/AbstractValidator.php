<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 17:00
 */

namespace NewInventor\EasyForm\Validator;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ArrayHelper;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class AbstractValidator implements ValidatorInterface
{
    protected $message;

    public function isValid($value)
    {
        return true;
    }

    public function getError()
    {
        return [];
    }
}