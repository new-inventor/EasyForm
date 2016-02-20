<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:32
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Interfaces\FieldInterface;

class TextArea extends AbstractField implements FieldInterface
{
    /**
     * @return string
     */
    public function getString()
    {
        return '<textarea name="' . $this->getFullName() .  '" ' . $this->attributes() . ' />' . $this->getValue() . '</textarea>';
    }
}