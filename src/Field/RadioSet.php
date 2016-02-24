<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 18:17
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Interfaces\FieldInterface;

class RadioSet extends ListField implements FieldInterface
{
    public function getString()
    {
        $res = '';
        foreach ($this->options() as $option) {
            $res .= '<input type="radio" name="' . $this->getFullName() . '"' . $this->attributes();
            $res .= ' value="' . $option['value'] . '"';
            if ($this->optionSelected($option['value'])) {
                $res .= ' checked';
            }
            $res .= '/>';
        }

        return $res;
    }
} 