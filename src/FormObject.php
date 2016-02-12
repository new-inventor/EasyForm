<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\Dictionary;
use NewInventor\EasyForm\Abstraction\NamedObject;
use NewInventor\EasyForm\Abstraction\TreeNode;

class FormObject extends NamedObject
{
    use TreeNode;
    /** @var Dictionary */
    private $attrs;
    private $title;

    function __construct($name, $title, array $attrs = [])
    {
        parent::__construct($name);
        $this->attrs = $attrs;
        $this->title = $title;
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

    public static function initFromArray(array $data)
    {
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}