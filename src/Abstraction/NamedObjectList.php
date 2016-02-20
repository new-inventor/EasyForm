<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:35
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\NamedObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;

class NamedObjectList extends ObjectList implements \Iterator, ObjectListInterface, RenderableInterface
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
        if (ObjectHelper::isValidType($objectsDelimiter, [ObjectHelper::STRING])) {
            $this->objectsDelimiter = $objectsDelimiter;

            return $this;
        }
        throw new ArgumentTypeException('objectsDelimiter', [ObjectHelper::STRING], $objectsDelimiter);
    }

    /**
     * @param NamedObjectInterface $object
     * @throws \Exception
     * @return $this
     */
    public function add($object)
    {
        if (ObjectHelper::isValidType($object, $this->getElementClasses())) {
            $this->objects[$object->getName()] = $object;

            return $this;
        }
        throw new ArgumentTypeException('object', $this->getElementClasses(), $object);
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
        $res = '';
        /** @var KeyValuePair $object */
        foreach($this->objects as $object){
            $res .= $object . $this->getObjectsDelimiter();
        }

        return $res;
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
        foreach ($this->getAll() as $name => $obj) {
            $res[$name] = $obj->toArray();
        }

        return $res;
    }
}