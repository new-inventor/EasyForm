<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\Dictionary;
use NewInventor\EasyForm\Interfaces\FormObjectInterface;

class FormObject
{
    /** @var Dictionary */
    private $attrs;
    private $name;
    private $title;

    function __construct($name, $title, array $attrs = [])
    {
        $this->attrs = $attrs;
        $this->name = $name;
        $this->title = $title;
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}