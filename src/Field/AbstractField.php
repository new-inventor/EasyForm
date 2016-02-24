<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:22
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\FormObject;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;
use NewInventor\EasyForm\Validator\ValidatableInterface;
use NewInventor\EasyForm\Validator\ValidatorInterface;

abstract class AbstractField extends FormObject implements FieldInterface, RenderableInterface
{
    /** @var array|string|null */
    private $value;


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
        if (ObjectHelper::isValidType($value, [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::NULL, ObjectHelper::INT, ObjectHelper::FLOAT, ObjectHelper::BOOL])) {
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

    public function getString()
    {
        return '';
    }

    public function children()
    {
        return null;
    }

    public function child($name)
    {
        return null;
    }

    public function clear(){
        $this->value = null;
        $type = $this->getAttribute('type');
        if($type !== null && $type != 'checkbox' && $type != 'radio') {
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
     * @inheritdoc
     */
    public function validator($name)
    {
        return $this->validators()->get($name);
    }
}