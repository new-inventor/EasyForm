<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 17:00
 */

namespace NewInventor\Form\Validator;

use NewInventor\Abstractions\Object;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

class AbstractValidator extends Object implements ValidatorInterface
{
    /** @var mixed */
    public $lastValidated;
    /** @var string */
    public $message;
    /** @var string */
    public $error;
    /** @var \Closure */
    protected $customValidateMethod;
    /** @var string */
    protected $objectName;
    
    /** @var bool */
    protected static $settingsInitialised = false;
    
    /**
     * AbstractValidator constructor.
     * @param string $message
     * @param \Closure|null $customValidateMethod
     */
    public function __construct($message = '', \Closure $customValidateMethod = null)
    {
        $this->setMessage($message);
        $this->customValidateMethod = $customValidateMethod;
    }
    
    protected function setMessage($message)
    {
        TypeChecker::getInstance()
            ->isString($message, 'message')
            ->throwTypeErrorIfNotValid();
        $this->message = $message;
    }
    
    /**
     * @return bool
     */
    public function isSettingsInitialised()
    {
        return self::$settingsInitialised;
    }
    
    /** @inheritdoc */
    public function isValid($value)
    {
        $this->lastValidated = $value;
        try {
            if (isset($this->customValidateMethod)) {
                $this->customValidateMethod->__invoke($this->objectName, $value);
            }
            return $this->validateValue($value);
        }catch (\Exception $e){
            $this->error = $e->getMessage();
            return false;
        }
    }
    
    protected function validateValue($value)
    {
        return true;
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * @param \Closure $customValidateMethod
     */
    public function setCustomValidateMethod(\Closure $customValidateMethod)
    {
        $this->customValidateMethod = $customValidateMethod;
    }
    
    /**
     * @param array $options
     * @throws ArgumentTypeException
     */
    public function setOptions(array $options)
    {
        foreach ($options as $argName => $arg) {
            TypeChecker::getInstance()
                ->isString($argName, 'argName')
                ->throwTypeErrorIfNotValid();
            $argName = 'set' . ucfirst($argName);
            $this->$argName($arg);
        }
    }

    /** @inheritdoc */
    public function setObjectName($objectName)
    {
        TypeChecker::getInstance()
            ->isString($objectName, 'objectName')
            ->throwTypeErrorIfNotValid();
        $this->objectName = $objectName;
    }
}