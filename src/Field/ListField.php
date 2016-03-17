<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 20:32
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\ObjectList;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;

abstract class ListField extends AbstractField {
    /** @var ObjectList */
    private $options;

    /**
     * RadioSet constructor.
     *
     * @param array|null  $options
     * @param string      $name
     * @param string|null $value
     * @param string      $title
     */
    public function __construct($name, $value = '', $title = '', array $options = null)
    {
        parent::__construct($name, $value, $title);
        $this->options = new ObjectList();
        if (isset($options)) {
            $this->addOptionArray($options);
        }
    }

    /**
     * @param string $title
     * @param string $value
     *
     * @return $this
     * @throws ArgumentTypeException
     */
    public function option($title, $value = '')
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
     *
     * @return $this
     * @throws ArgumentTypeException
     */
    public function addOptionArray(array $options = [])
    {
        foreach ($options as $value => $title) {
            $this->option($title, $value);
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
     *
     * @return array|null
     * @throws ArgumentTypeException
     */
    public function getOption($key)
    {
        return $this->options()->get($key);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function optionSelected($value)
    {
        return $value == $this->getValue();
    }
} 