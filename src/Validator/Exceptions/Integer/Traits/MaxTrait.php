<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 15:37
 */

namespace NewInventor\Form\Validator\Exceptions\Integer\Traits;


use NewInventor\TypeChecker\TypeChecker;

trait MaxTrait
{
    protected $max;
    
    protected function setMax($max)
    {
        
        TypeChecker::getInstance()
            ->isInt($max, 'maxValue')
            ->throwTypeErrorIfNotValid();
        $this->max = $max;
    }

    public function max()
    {
        return (string)$this->max;
    }
}