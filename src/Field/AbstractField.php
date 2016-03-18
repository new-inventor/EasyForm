<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:22
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\ObjectList;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\FormObject;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;
use NewInventor\EasyForm\Settings;
use NewInventor\EasyForm\Validator\AbstractValidator;
use NewInventor\EasyForm\Validator\ValidatorInterface;

abstract class AbstractField extends FormObject implements FieldInterface
{
    /** @var array|string|null */
    private $value;
    /** @var ObjectListInterface */
    protected $validators;


    /**
     * AbstractField constructor.
     * @param string $name
     * @param mixed $value
     * @param string $title
     */
    public function __construct($name, $value, $title = '')
    {
        parent::__construct($name, $title);
        $this->setValue($value);
        $this->validators = new ObjectList(['NewInventor\EasyForm\Validator\ValidatorInterface']);
    }

    /**
     * @param string $name
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setName($name)
    {
        parent::setName($name);

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setValue($value)
    {
        if (ObjectHelper::is($value, [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::NULL, ObjectHelper::INT, ObjectHelper::FLOAT, ObjectHelper::BOOL])) {
            $this->value = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::NULL, ObjectHelper::INT, ObjectHelper::FLOAT, ObjectHelper::BOOL], $value);
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res['value'] = $this->getValue();

        return $res;
    }

    public function validate()
    {
        /** @var ValidatorInterface $validator */
        foreach ($this->validators() as $validator) {
            if ($validator->isValid($this->getValue())) {
                continue;
            }
            $this->isValid = false;
            $this->errors[] = $validator->getError();
        }
    }

    public function children()
    {
        return null;
    }

    public function child($name)
    {
        return null;
    }

    public function clear()
    {
        $this->value = null;
        $type = $this->getAttribute('type');
        if ($type !== null && $type != 'checkbox' && $type != 'radio') {
            $this->attribute('value', '');
        }
    }


    /**
     * @inheritdoc
     */
    public function validators()
    {
        return $this->validators;
    }

    /**
     * @param $name
     * @return ValidatorInterface|null
     * @throws ArgumentTypeException
     */
    public function getValidator($name)
    {
        return $this->validators()->get($name);
    }

    /**
     * @inheritdoc
     */
    public function validator($validator, array $options = [])
    {
        $validatorObj = null;
        if (is_string($validator)) {
           $validatorObj = $this->generateInnerValidator($validator);
        } elseif ($validator instanceof \Closure) {
            $validatorObj = $this->generateCustomValidator($validator);
        } elseif($validator instanceof ValidatorInterface){
            $validatorObj = $validator;
        }else{
            throw new ArgumentException('Передан неправильный валидатор.', 'validator');
        }
        $validatorObj->field($this);
        $validatorObj->setOptions($options);
        $this->validators()->add($validatorObj);

        return $this;
    }

    protected function generateInnerValidator($validatorName)
    {
        AbstractValidator::initSettings();
        $validatorClassName = Settings::getInstance()->get(['validator', $validatorName]);
        if (class_exists($validatorClassName) && in_array('NewInventor\EasyForm\Validator\ValidatorInterface', class_implements($validatorClassName))) {
            /** @var ValidatorInterface $validatorObj */
            $validatorObj = new $validatorClassName();
        }else{
            throw new ArgumentException('Класс для валидатора не найден.', 'validatorName');
        }

        return $validatorObj;
    }

    protected function generateCustomValidator($validator)
    {
        $validatorObj = new AbstractValidator();
        $validatorObj->setCustomValidateMethod($validator);

        return $validatorObj;
    }

    /** @inheritdoc */
    public function prepareErrors(array $errors = [])
    {
        return $errors;
    }

    /**
     * @inheritdoc
     */
    public function isRepeatable()
    {
        return $this->getParent() !== null && $this->getParent()->isRepeatableContainer();
    }
}