<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Interfaces\FormObjectInterface;

class FormObject
{
    private $parent = null;
    private $children = null;
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
     * @return FormObjectInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param FormObjectInterface[] $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @param string $name
     *
     * @return FormObjectInterface
     */
    public function getChild($name)
    {
        return $this->children[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function deleteChild($name)
    {
        if (isset($this->children[$name])) {
            unset($this->children[$name]);
            return true;
        }
        return false;
    }

    /**
     * @param FormObjectInterface $child
     */
    public function addChild($child)
    {
        $this->children[$child->getName()] = $child;
    }

    /**
     * @return FormObjectInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param FormObjectInterface $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getAttr($name)
    {
        return $this->attrs[$name];
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setAttr($name, $value)
    {
        $this->attrs[$name] = $value;
    }

    /**
     * @return array
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    public function deleteAttr($name)
    {
        if (isset($this->attrs[$name])) {
            unset($this->attrs[$name]);
            return true;
        }
        return false;
    }

    /**
     * @param array $attrs
     */
    public function setAttrs(array $attrs)
    {
        $this->attrs = $attrs;
    }

    /**
     * @param array $attrs
     */
    public function addAttrs(array $attrs)
    {
        $this->attrs = array_merge($this->attrs, $attrs);
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