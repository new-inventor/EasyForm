<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:20
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Exception\ArgumentTypeException;

trait TreeNode
{
    private $parent = null;
    private $children = null;


    /**
     * @return mixed[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed[] $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getChild($name)
    {
        return $this->children[$name];
    }

    /**
     * @param string $name
     * @throws ArgumentTypeException
     */
    public function deleteChild($name)
    {
        if(ObjectHelper::isValidArgumentType($name, [ObjectHelper::STRING])){
            unset($this->children[$name]);
        }

        throw new ArgumentTypeException('name', [ObjectHelper::STRING], $name);
    }

    /**
     * @param mixed $child
     */
    public function addChild($child)
    {
        $this->children[$child->getName()] = $child;
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