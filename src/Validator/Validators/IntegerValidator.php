<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\Form\Validator\Validators;

use NewInventor\Form\Validator\AbstractValidator;
use NewInventor\Form\Validator\Exceptions\Integer;
use NewInventor\Form\Validator\ValidatorInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

class IntegerValidator extends AbstractValidator implements ValidatorInterface
{
    protected $min;
    protected $max;
    
    protected $minMessage = '';
    protected $maxMessage = '';
    protected $rangeMessage = '';
    
    public function validateValue($value)
    {
        if (empty($value) && is_string($value)) {
            return true;
        }
        if (!is_numeric($value)) {
            throw new Integer\Base($this->objectName);
        }
        $value = (string)$value;
        $testValue = (string)((int)((string)$value));
        if (mb_strlen($value) != mb_strlen($testValue)) {
            throw new Integer\Base($this->objectName);
        }
        $value = (int)$value;
        if (isset($this->min) && isset($this->max) && ($value < $this->min || $value > $this->max)) {
            throw new Integer\Range($this->objectName, $this->min, $this->max, $this->rangeMessage);
        }
        if (isset($this->min) && $value < $this->min) {
            throw new Integer\Min($this->objectName, $this->min, $this->minMessage);
        }
        if (isset($this->max) && $value > $this->max) {
            throw new Integer\Max($this->objectName, $this->max, $this->maxMessage);
        }
        
        return true;
    }
    
    /**
     * @param int $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMin($value)
    {
        TypeChecker::getInstance()
            ->isInt($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->min = $value;
        
        return $this;
    }
    
    /**
     * @param int $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMax($value)
    {
        TypeChecker::getInstance()
            ->isInt($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->max = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMinMessage($value)
    {
        TypeChecker::getInstance()
            ->isInt($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->minMessage = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMaxMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->maxMessage = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setRangeMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->rangeMessage = $value;
        
        return $this;
    }
}