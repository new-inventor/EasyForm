<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 20:10
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class CheckBox extends AbstractField implements FieldInterface
{
    /**
     * AbstractField constructor.
     *
     * @param string            $name
     * @param bool|null         $value
     * @param string            $title
     */
    public function __construct($name, $value = false, $title = '')
    {
        parent::__construct($name, $value, $title);
        $this->attribute('type', 'checkbox');
    }

    public function setValue($value)
    {
        if (ObjectHelper::isValidType($value, [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::BOOL, ObjectHelper::NULL])) {
            if(is_string($value)){
                parent::setValue(true);
            }else {
                parent::setValue($value);
            }

            return $this;
        }
        throw new ArgumentTypeException('value', [ObjectHelper::STRING, ObjectHelper::ARR, ObjectHelper::BOOL, ObjectHelper::NULL], $value);
    }

    /**
     * @return string
     */
    public function getString()
    {
        $res = '<input name="' . $this->getFullName() . '" ' . $this->attributes();
        if($this->getValue()){
            $res .= ' checked';
        }
        $res .= '/>';

        return $res;
    }
} 