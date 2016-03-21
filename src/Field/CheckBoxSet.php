<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 20:30
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\SimpleTypes;
use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class CheckBoxSet extends ListField implements FieldInterface
{
    /**
     * Select constructor.
     *
     * @param array|null $options
     * @param string $name
     * @param string|array|null $value
     * @param string $title
     */
    public function __construct($name, $value = '', $title = '', array $options = [])
    {
        parent::__construct($name, null, $title, $options);
        $this->setValue($value);
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        TypeChecker::getInstance()
            ->check($value, [SimpleTypes::STRING, SimpleTypes::ARR, SimpleTypes::NULL], 'value')
            ->throwTypeErrorIfNotValid();
        if (is_string($value)) {
            parent::setValue([$value]);
        } elseif (is_array($value)) {
            parent::setValue($value);
        } else {
            parent::setValue([]);
        }

        return $this;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function optionSelected($value)
    {
        return array_search($value, $this->getValue()) !== false;
    }
} 