<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:33
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\ObjectList;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class Select extends AbstractField implements FieldInterface
{
    /** @var ObjectList */
    private $options;

    /**
     * Select constructor.
     * @param array|null $options
     * @param string $name
     * @param string|array|null $value
     * @param string $title
     * @param bool $repeatable
     */
    public function __construct($name, $value = '', $title = '', array $options = [], $repeatable = false)
    {
        parent::__construct($name, null, $title, $repeatable);
        if (is_string($value)) {
            $this->setValue([$value]);
        } elseif (is_array($value)) {
            $this->setValue($value);
        } else {
            $this->setValue([]);
        }
        $this->options = new ObjectList();
        if (isset($options)) {
            $this->addOptionArray($options);
        }
    }

    /**
     * @param string $title
     * @param string $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function addOption($title, $value = '')
    {
        if (!ObjectHelper::isValidType($title, [ObjectHelper::STRING])) {
            throw new ArgumentTypeException('title', [ObjectHelper::STRING], $title);
        }
        if (!ObjectHelper::isValidType($value, [ObjectHelper::STRING, ObjectHelper::INT, ObjectHelper::FLOAT, ObjectHelper::NULL])) {
            throw new ArgumentTypeException('value', [ObjectHelper::STRING, ObjectHelper::INT, ObjectHelper::FLOAT, ObjectHelper::NULL], $value);
        }
        $option = [
            'title' => $title,
            'value' => $value
        ];

        $this->options()->add($option);

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     * @throws ArgumentTypeException
     */
    public function addOptionArray(array $options = [])
    {
        foreach ($options as $value => $title) {
            $this->addOption($title, $value);
        }

        return $this;
    }

    /**
     * @return ObjectList
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * @param int|string $key
     * @return array|null
     * @throws ArgumentTypeException
     */
    public function option($key)
    {
        return $this->options()->get($key);
    }

    /**
     * @return string
     */
    public function getString()
    {
        $res = '<select name="' . $this->getFullName() .  '" ' . $this->attributes() . ' />';
        foreach ($this->options() as $option) {
            $optionString = '<option value="' . $option['value'] . '"';
            if($this->optionSelected($option['value'])){
                $optionString .= ' selected="selected"';
            }
            $optionString .= '>' . $option['title'] . '</option>';
            $res .= $optionString;
        }
        $res .= '</select>';

        return $res;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function optionSelected($value)
    {
        return array_search($value, $this->getValue()) !== false;
    }
}