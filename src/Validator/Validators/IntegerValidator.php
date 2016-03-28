<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\EasyForm\Validator\Validators;

use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Validator\AbstractValidator;
use NewInventor\EasyForm\Validator\ValidatorInterface;

class IntegerValidator extends AbstractValidator implements ValidatorInterface
{
    protected $min;
    protected $max;

    protected $minMessage = 'Значение поля "{f}" должно быть больше {min}.';
    protected $maxMessage = 'Значение поля "{f}" должно быть меньше {max}.';
    protected $minMaxMessage = 'Значение поля "{f}" должно быть между {min} и {max}.';

    protected $error = '';

    /**
     * IntegerValidator constructor.
     * @param \Closure|null $customValidateMethod
     */
    public function __construct(\Closure $customValidateMethod = null)
    {
        parent::__construct('Значение поля "{f}" не является целым числом.', $customValidateMethod);
    }

    public function validateValue($value)
    {
        if (empty($value) && is_string($value)) {
            return true;
        }
        if (!is_numeric($value)) {
            $this->error = $this->message;

            return false;
        }
        $value = (string)$value;
        $testValue = (string)((int)((string)$value));
        if (mb_strlen($value) != mb_strlen($testValue)) {
            $this->error = $this->message;

            return false;
        }
        $value = (int)$value;
        if (isset($this->min) && isset($this->max) && ($value < $this->min || $value > $this->max)) {
            $this->error = str_replace(['{min}', '{max}'], [$this->min, $this->max], $this->minMaxMessage);

            return false;
        }
        if (isset($this->min) && $value < $this->min) {
            $this->error = str_replace('{min}', $this->min, $this->minMessage);

            return false;
        }
        if (isset($this->max) && $value > $this->max) {
            $this->error = str_replace('{max}', $this->max, $this->maxMessage);

            return false;
        }

        return true;
    }

    public function getError()
    {
        return $this->replaceFieldName($this->error);
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
    public function setMinMaxMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->minMaxMessage = $value;

        return $this;
    }
}