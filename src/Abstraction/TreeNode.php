<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:20
 */

namespace NewInventor\EasyForm\Abstraction;

trait TreeNode
{
    private $parent = null;
    private $children = null;


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
        if(isset($this->children[$name])){
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
}