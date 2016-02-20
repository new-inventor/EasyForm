<?php

namespace NewInventor\EasyForm\Interfaces;

use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;

interface FormInterface extends BlockInterface
{



    public function isValidEncType($encType);

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $method
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMethod($method);

    /**
     * @return string
     */
    public function getAction();

    /**
     * @param string $action
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setAction($action);

    /**
     * @return string
     */
    public function getEncType();

    /**
     * @param string $encType
     * @return $this
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function setEncType($encType);
}