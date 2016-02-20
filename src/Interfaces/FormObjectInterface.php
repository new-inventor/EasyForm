<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\FormObject;

interface FormObjectInterface extends NamedObjectInterface
{
    /**
     * @param string $title
     * @return static
     * @throws ArgumentTypeException
     */
    public function setTitle($title);

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
     * @return bool
     */
    public function isRepeatable();

    /**
     * @return static
     */
    public function repeatable();

    /**
     * @return static
     */
    public function single();

    /**
     * @return ObjectListInterface
     */
    public function attributes();

    /**
     * @param $name
     * @return ObjectListInterface
     * @throws ArgumentTypeException
     */
    public function attribute($name);

    /**
     * @return string
     */
    public function getFullName();

    public function children();

    public function initChildren($childrenContainer);

    /**
     * @param string $name
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
}