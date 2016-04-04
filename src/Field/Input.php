<?php

namespace NewInventor\Form\Field;

use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Interfaces\FieldInterface;

class Input extends AbstractField implements FieldInterface
{
    /** @inheritdoc */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->attributes()->add(new KeyValuePair('value', $value));

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function type($type)
    {
        $this->attribute('type', $type);

        return $this;
    }
}