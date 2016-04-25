<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 16:57
 */

namespace NewInventor\Form\Validator\Exceptions\String\Traits;


use NewInventor\TypeChecker\TypeChecker;

trait MinLengthTrait
{
    protected $minLength;

    protected function setMinLength($minLength)
    {

        TypeChecker::getInstance()
            ->isInt($minLength, 'minLength')
            ->throwTypeErrorIfNotValid();
        $this->minLength = $minLength;
    }

    public function minLength()
    {
        return (string)$this->minLength;
    }
}