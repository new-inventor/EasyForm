<?php

namespace NewInventor\EasyForm;

use Interfaces\ValidatorInterface;
use NewInventor\EasyForm\Abstraction\ObjectList;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class AbstractField extends FormObject implements FieldInterface
{
    /** @var array|string|null */
    private $value;
    /** @var ObjectList */
    private $validators;
    /** @var array */
    private $errors;
    private $isValid;

    /**
     * AbstractField constructor.
     * @param string $name
     * @param string $value
     * @param string $title
     * @param bool $repeatable
     */
    public function __construct($name, $value = '', $title = '', $repeatable = false)
    {
        parent::__construct($name, $title, $repeatable);
        $this->setValue($value);
        $this->validators = new ObjectList([]);
        $this->isValid = true;
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
        if (ObjectHelper::isValidArgumentType($value, [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::NULL])) {
            $this->value = $value;

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::NULL], $value);
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res['value'] = $this->getValue();

        return $res;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @return ObjectList
     */
    public function validators()
    {
        return $this->validators;
    }

    public function validator($name)
    {
        return $this->validators->get($name);
    }

    public function validate()
    {
        /** @var ValidatorInterface $validator */
        foreach ($this->validators() as $validator) {
            if ($validator->isValid()) {
                continue;
            }
            $this->isValid = false;
            $this->errors[] = $validator->getError();
        }
    }
}