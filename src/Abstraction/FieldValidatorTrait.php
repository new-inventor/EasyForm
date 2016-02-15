<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 18:09
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;

trait FieldValidatorTrait
{

    public function setField($name, $value, array $expectedTypes = [])
    {
        if(ObjectHelper::isValidArgumentType($value, $expectedTypes)){
            $this->$name = $value;

            return $this;
        }
        throw new ArgumentTypeException($name, $expectedTypes, $value);
    }
}