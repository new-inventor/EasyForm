<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:33
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Interfaces\FieldInterface;

class Select extends CheckBoxSet implements FieldInterface
{
    /**
     * @return string
     */
    public function getString()
    {
        $res = '<select name="' . $this->getFullName() . '" ' . $this->attributes() . '>';
        foreach ($this->options() as $option) {
            $optionString = '<option value="' . $option['value'] . '"';
            if ($this->optionSelected($option['value'])) {
                $optionString .= ' selected="selected"';
            }
            $optionString .= '>' . $option['title'] . '</option>';
            $res .= $optionString;
        }
        $res .= '</select>';

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function getFullName()
    {
        $name = parent::getFullName();
        if ($this->isMultiple()) {
            $name .= '[]';
        }

        return $name;
    }

    public function isMultiple(){
        return $this->getAttribute('multiple') !== null;
    }

    /**
     * @return $this
     */
    public function multiple()
    {
        $this->attribute('multiple');

        return $this;
    }

    /**
     * @return $this
     */
    public function single()
    {
        $this->attributes()->delete('multiple');

        return $this;
    }
}