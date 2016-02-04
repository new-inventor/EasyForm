<?php

namespace NewInventor\EasyForm\Interfaces;


interface FormObjectInterface
{
    /**
     * @param $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $title
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * Object to string
     * @return string
     */
    public function __toString();

    /**
     * get parent object
     * @return FormInterface|BlockInterface
     */
    public function end();

    /**
     * Convert object to array
     * @return array
     */
    public function toArray();
}