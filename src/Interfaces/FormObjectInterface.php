<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentTypeException;

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
     *
     * @return $this
     * @throws ArgumentTypeException
     */
    public function attribute($name, $value = '');

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
     * @return \NewInventor\EasyForm\Interfaces\NamedObjectInterface
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
}