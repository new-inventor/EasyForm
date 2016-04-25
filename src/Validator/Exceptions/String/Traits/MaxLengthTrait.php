<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 16:57
 */

namespace NewInventor\Form\Validator\Exceptions\String\Traits;


use NewInventor\TypeChecker\TypeChecker;

trait MaxLengthTrait
{
    protected $maxLength;

    protected function setMaxLength($maxLength)
    {

        TypeChecker::getInstance()
            ->isInt($maxLength, 'maxLength')
            ->throwTypeErrorIfNotValid();
        $this->maxLength = $maxLength;
    }

    public function maxLength()
    {
        return (string)$this->maxLength;
    }
}