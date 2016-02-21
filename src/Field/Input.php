<?php

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class Input extends AbstractField implements FieldInterface
{
    /** @inheritdoc */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->attributes()->add(HtmlAttr::build('value', $value));

        return $this;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return '<input name="' . $this->getFullName() . '" ' . $this->attributes() . ' />';
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