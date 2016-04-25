<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\Form\Validator\Validators;

use NewInventor\Form\Validator\AbstractValidator;
use NewInventor\Form\Validator\Exceptions\String;
use NewInventor\Form\Validator\ValidatorInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

class StringValidator extends AbstractValidator implements ValidatorInterface
{
    protected $length;
    protected $minLength;
    protected $maxLength;
    protected $regexp;
    
    protected $lengthMessage = '';
    protected $minLengthMessage = '';
    protected $maxLengthMessage = '';
    protected $rangeLengthMessage = '';
    protected $regexpMessage = '';
    
    /**
     * IntegerValidator constructor.
     * @param string $message
     * @param \Closure|null $customValidateMethod
     */
    public function __construct($message = '', \Closure $customValidateMethod = null)
    {
        parent::__construct($message, $customValidateMethod);
    }
    
    public function validateValue($value)
    {
        if (!is_string($value)) {
            throw new String\Base($this->objectName, $this->message);
        }
        if (mb_strlen($value) == 0) {
            return true;
        }
        if (!is_null($this->length) && mb_strlen($value) !== $this->length) {
            throw new String\Length($this->objectName, $this->length, $this->lengthMessage);
        }
        if (!is_null($this->maxLength) && !is_null($this->minLength) && (mb_strlen($value) > $this->maxLength || mb_strlen($value) < $this->minLength)) {
            throw new String\RangeLength($this->objectName, $this->minLength, $this->maxLength, $this->rangeLengthMessage);
        }
        if (!is_null($this->minLength) && mb_strlen($value) < $this->minLength) {
            throw new String\MinLength($this->objectName, $this->minLength, $this->minLengthMessage);
        }
        if (!is_null($this->maxLength) && mb_strlen($value) > $this->maxLength) {
            throw new String\MaxLength($this->objectName, $this->maxLength, $this->maxLengthMessage);
        }
        if (!is_null($this->regexp)) {
            preg_match($this->regexp, $value, $matches);
            if (count($matches) > 1 || empty($matches)) {
                throw new String\Regexp($this->objectName, $this->regexpMessage);
            }
        }
        
        return true;
    }
    
    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMinLength($value)
    {
        TypeChecker::getInstance()
            ->isInt($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->minLength = $value;
        
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMaxLength($value)
    {
        TypeChecker::getInstance()
            ->isInt($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->maxLength = $value;
        
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setLength($value)
    {
        TypeChecker::getInstance()
            ->isInt($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->length = $value;
        
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setRegexp($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->regexp = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setLengthMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->lengthMessage = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMinLengthMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->minLengthMessage = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMaxLengthMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->maxLengthMessage = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setRangeLengthMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->rangeLengthMessage = $value;
        
        return $this;
    }
    
    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setRegexpMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->regexpMessage = $value;
        
        return $this;
    }
}