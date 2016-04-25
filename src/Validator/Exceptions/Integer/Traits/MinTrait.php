<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 15:37
 */

namespace NewInventor\Form\Validator\Exceptions\Integer\Traits;


use NewInventor\TypeChecker\TypeChecker;

trait MinTrait
{
    protected $min;
    
    protected function setMin($min)
    {
        
        TypeChecker::getInstance()
            ->isInt($min, 'minValue')
            ->throwTypeErrorIfNotValid();
        $this->min = $min;
    }

    public function min()
    {
        return (string)$this->min;
    }
}