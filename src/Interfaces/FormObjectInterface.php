<?php

namespace NewInventor\Form\Interfaces;


use NewInventor\Abstractions\Interfaces\NamedObjectInterface;
use NewInventor\Abstractions\Interfaces\ObjectListInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

interface FormObjectInterface extends NamedObjectInterface
{
    /**
     * @param string $title
     *
     * @return static
     * @throws ArgumentTypeException
     */
    public function title($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * get parent object
     * @return FormInterface|BlockInterface
     */
    public function end();

    /**
     * @return ObjectListInterface
     */
    public function attributes();

    /**
     * @param string $name
     * @param string $value
     * @param bool $canBeShort
     *
     * @return $this
     * @throws ArgumentTypeException
     */
    public function attribute($name, $value = '', $canBeShort = false);

    /**
     * @param $name
     *
     * @return NamedObjectInterface
     * @throws ArgumentTypeException
     */
    public function getAttribute($name);

    /**
     * @return string
     */
    public function getFullName();

    /**
     * @return ObjectListInterface
     */
    public function children();

    /**
     * @param string $name
     *
     * @return NamedObjectInterface
     * @throws ArgumentTypeException
     */
    public function child($name);

    /**
     * @return mixed
     */
    public function getParent();

    /**
     * @param mixed $parent
     */
    public function setParent($parent);


    /**
     * @return array
     */
    public function getDataArray();

    /**
     * @return bool
     */
    public function isRepeatable();

    /**
     * @param string $name
     * @return static
     * @throws ArgumentTypeException
     */
    public function template($name);

    /**
     * @return string
     */
    public function getTemplate();
}