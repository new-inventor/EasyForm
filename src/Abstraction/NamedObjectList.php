<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:35
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Interfaces\NamedObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;

class NamedObjectList extends ObjectList implements \Iterator, ObjectListInterface, RenderableInterface, \Countable
{
    /** @var string */
    private $objectsDelimiter;

    /**
     * @return string
     */
    public function getObjectsDelimiter()
    {
        return $this->objectsDelimiter;
    }

    /**
     * @param string $objectsDelimiter
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setObjectsDelimiter($objectsDelimiter)
    {
        TypeChecker::getInstance()
            ->isString($objectsDelimiter, 'objectsDelimiter')
            ->throwTypeErrorIfNotValid();
        $this->objectsDelimiter = $objectsDelimiter;

        return $this;
    }

    /**
     * @param NamedObjectInterface $object
     * @throws \Exception
     * @return $this
     */
    public function add($object)
    {
        TypeChecker::getInstance()
            ->check($object, $this->getElementClasses(), 'object')
            ->throwTypeErrorIfNotValid();
        $this->objects[$object->getName()] = $object;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getString();
    }

    /**
     * @inheritdoc
     */
    public function getString()
    {
        return implode($this->getObjectsDelimiter(), $this->objects);
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        echo $this->getString();
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $res = [];
        /**
         * @var string $name
         * @var Object $obj
         */
        foreach ($this->getAll() as $name => $obj) {
            $res[$name] = $obj->toArray();
        }

        return $res;
    }
}