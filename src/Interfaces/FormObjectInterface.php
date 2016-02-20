<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentTypeException;

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
}