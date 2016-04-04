<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 20:32
 */

namespace NewInventor\Form\Field;


use NewInventor\Abstractions\ObjectList;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\SimpleTypes;
use NewInventor\TypeChecker\TypeChecker;

abstract class ListField extends AbstractField
{
    /** @var ObjectList */
    private $options;

    /**
     * RadioSet constructor.
     *
     * @param array|null $options
     * @param string $name
     * @param string|null $value
     * @param string $title
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
        TypeChecker::getInstance()
            ->isString($title, 'title')
            ->throwTypeErrorIfNotValid();
        TypeChecker::getInstance()
            ->check($value, [SimpleTypes::STRING, SimpleTypes::INT, SimpleTypes::FLOAT, SimpleTypes::NULL], 'title')
            ->throwTypeErrorIfNotValid();
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