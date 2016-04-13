<?php

namespace NewInventor\Form\Interfaces;


use NewInventor\Abstractions\NamedObjectList;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

interface FormInterface extends BlockInterface
{

    /**
     * @param string $encType
     *
     * @return bool
     */
    public function isValidEncType($encType);

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $method
     *
     * @return FormInterface
     * @throws ArgumentTypeException
     */
    public function method($method);

    /**
     * @return string
     */
    public function getAction();

    /**
     * @param string $action
     *
     * @return FormInterface
     * @throws ArgumentTypeException
     */
    public function action($action);

    /**
     * @return string
     */
    public function getEncType();

    /**
     * @param string $encType
     *
     * @return FormInterface
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function encType($encType);

    /**
     * @return NamedObjectList
     */
    public function handlers();

    /**
     * @param callable|\Closure|HandlerInterface $handler Handler type
     * @param string                           $name
     * @param string                           $value
     *
     * @return FormInterface
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function handler($handler, $name = 'abstract', $value = 'Абстрактное действие');

    /**
     * @param array|null $customData
     *
     * @return bool
     */
    public function save(array $customData = null);
}