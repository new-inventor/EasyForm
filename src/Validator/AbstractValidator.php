<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 17:00
 */

namespace NewInventor\EasyForm\Validator;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class AbstractValidator implements ValidatorInterface
{
    /** @var mixed */
    public $lastValidated;
    /** @var string */
    public $message;
    /** @var \Closure */
    protected $customValidateMethod;
    /** @var FieldInterface */
    protected $field;

    /**
     * AbstractValidator constructor.
     * @param string $message
     * @param \Closure|null $customValidateMethod
     */
    public function __construct($message = 'Ошибка в поле', \Closure $customValidateMethod = null)
    {
        $this->message = $message;
        $this->customValidateMethod = $customValidateMethod;
    }

    /** @inheritdoc */
    public function isValid($value)
    {
        $this->lastValidated = $value;
        if (isset($this->customValidateMethod)) {
            return $this->customValidateMethod->__invoke($value);
        }

        return $this->validateValue($value);
    }

    protected function validateValue($value)
    {
        return true;
    }

    public function getError()
    {
        return $this->message;
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
            if (!is_string($argName)) {
                throw new ArgumentTypeException('argName', [ObjectHelper::STRING], $argName);
            }
            $argName = 'set' . ucfirst($argName);
            $this->$argName($arg);
        }
    }

    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMessage($value)
    {
        if (ObjectHelper::isValidType($value, [ObjectHelper::STRING])) {
            $this->message = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING], $value);
    }

    /**
     * @param FieldInterface $field
     */
    public function field(FieldInterface $field)
    {
        $this->field = $field;
    }

    public function __call($name, $params)
    {
        throw new \Exception("Не найден параметр '{$name}' в классе.");
    }
}