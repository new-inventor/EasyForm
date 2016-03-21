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

class StringValidator extends AbstractValidator implements ValidatorInterface
{
    protected $length;
    protected $minLength;
    protected $maxLength;
    protected $regexp;

    protected $lengthMessage = 'Длина значения поля "{f}" должна быть {length} символов.';
    protected $minLengthMessage = 'Длина значения поля "{f}" должна быть больше {minLength} символов.';
    protected $maxLengthMessage = 'Длина значения поля "{f}" должна быть меньше {maxLength} символов.';
    protected $minMaxLengthMessage = 'Длина значения поля "{f}" должна быть между {minLength} и {maxLength} символами.';
    protected $regexpMessage = 'Значение поля "{f}" не удовлетворяет правилам.';

    protected $error = '';

    /**
     * IntegerValidator constructor.
     * @param \Closure|null $customValidateMethod
     */
    public function __construct(\Closure $customValidateMethod = null)
    {
        parent::__construct('Значение поля "{f}" не является строкой.', $customValidateMethod);
    }

    public function validateValue($value)
    {
        if (!is_string($value)) {
            $this->error = $this->message;

            return false;
        }
        if(mb_strlen($value) == 0){
            return true;
        }
        if (!is_null($this->length) && mb_strlen($value) !== $this->length) {
            $this->error = preg_replace('/\{length\}/u', $this->length, $this->lengthMessage);

            return false;
        }
        if (!is_null($this->maxLength) && !is_null($this->minLength) && (mb_strlen($value) > $this->maxLength || mb_strlen($value) < $this->minLength)) {
            $this->error = preg_replace(['/\{minLength\}/u'], $this->minLength, $this->minMaxLengthMessage);
            $this->error = preg_replace(['/\{maxLength\}/u'], $this->maxLength, $this->error);

            return false;
        }
        if (!is_null($this->minLength) && mb_strlen($value) < $this->minLength) {
            $this->error = preg_replace('/\{minLength\}/u', $this->minLength, $this->minLengthMessage);

            return false;
        }
        if (!is_null($this->maxLength) && mb_strlen($value) > $this->maxLength) {
            $this->error = preg_replace('/\{maxLength\}/u', $this->maxLength, $this->maxLengthMessage);

            return false;
        }
        if (!is_null($this->regexp)) {
            preg_match($this->regexp, $value, $matches);
            if(count($matches) > 1 || empty($matches)){
                $this->error = $this->regexpMessage;

                return false;
            }
        }

        return true;
    }

    public function getError()
    {
        return $this->replaceFieldName($this->error);
    }

    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMinLength($value){
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
    public function setMaxLength($value){
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
    public function setLength($value){
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
    public function setRegexp($value){
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
    public function setMinMaxLengthMessage($value)
    {
        TypeChecker::getInstance()
            ->isString($value, 'value')
            ->throwTypeErrorIfNotValid();
        $this->minMaxLengthMessage = $value;

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