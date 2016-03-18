<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\EasyForm\Validator\Validators;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
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
        if(empty($value) && is_string($value)){
            return true;
        }
        if (!is_numeric($value)) {
            $this->error = $this->message;

            return false;
        }
        $value = (string)$value;
        $testValue = (string)((int)((string)$value));
        if(mb_strlen($value) != mb_strlen($testValue)){
            $this->error = $this->message;

            return false;
        }
        $value = (int)$value;
        if (isset($this->min) && isset($this->max) && ($value < $this->min || $value > $this->max)) {
            $this->error = preg_replace('/\{min\}/u', $this->min, $this->minMaxMessage);
            $this->error = preg_replace('/\{max\}/u', $this->max, $this->error);

            return false;
        }
        if (isset($this->min) && $value < $this->min) {
            $this->error = preg_replace('/\{min\}/u', $this->min, $this->minMessage);

            return false;
        }
        if (isset($this->max) && $value > $this->max) {
            $this->error = preg_replace('/\{max\}/u', $this->max, $this->maxMessage);

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
    public function setMin($value){
        if (ObjectHelper::is($value, [ObjectHelper::INT])) {
            $this->min = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::INT], $value);
    }

    /**
     * @param int $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMax($value){
        if (ObjectHelper::is($value, [ObjectHelper::INT])) {
            $this->max = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::INT], $value);
    }

    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMinMessage($value)
    {
        if (ObjectHelper::is($value, [ObjectHelper::STRING])) {
            $this->minMessage = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING], $value);
    }

    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMaxMessage($value)
    {
        if (ObjectHelper::is($value, [ObjectHelper::STRING])) {
            $this->maxMessage = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING], $value);
    }

    /**
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMinMaxMessage($value)
    {
        if (ObjectHelper::is($value, [ObjectHelper::STRING])) {
            $this->minMaxMessage = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING], $value);
    }
}