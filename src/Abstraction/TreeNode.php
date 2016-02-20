<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:20
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentTypeException;

trait TreeNode
{
    private $parent = null;
    /** @var mixed $children */
    private $children = null;


    /**
     * @return mixed
     */
    public function children()
    {
        return $this->children;
    }

    public function initChildren($childrenContainer)
    {
        $this->children = $childrenContainer;
    }

    /**
     * @param string $name
     * @return \NewInventor\EasyForm\Interfaces\NamedObjectInterface
     * @throws ArgumentTypeException
     */
    public function child($name)
    {
        return $this->children->get($name);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}