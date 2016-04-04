<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:33
 */

namespace NewInventor\Form\Field;

use NewInventor\Form\Interfaces\FieldInterface;

class Select extends CheckBoxSet implements FieldInterface
{
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