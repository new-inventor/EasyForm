<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:35
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ArrayHelper;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\NamedObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;

class ObjectList implements \Iterator, ObjectListInterface
{
    /** @var array */
    private $objects;
    /** @var string */
    private $objectsDelimiter;
    /** @var string */
    private $elementClasses;


    public function __construct(array $elementClasses = [])
    {
        $this->setElementClasses($elementClasses);
    }

    /**
     * @param $elementClasses
     * @return $this
     * @throws ArgumentException
     */
    public function setElementClasses(array $elementClasses = [])
    {
        if (ArrayHelper::isValidElementsTypes($elementClasses, [ObjectHelper::STRING])) {
            $this->elementClasses = $elementClasses;

            return $this;
        }
        throw new ArgumentException('Переданы  неправильные классы', 'elementClasses');
    }

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
        if (ObjectHelper::isValidArgumentType($objectsDelimiter, [ObjectHelper::STRING])) {
            $this->objectsDelimiter = $objectsDelimiter;

            return $this;
        }
        throw new ArgumentTypeException('objectsDelimiter', [ObjectHelper::STRING], $objectsDelimiter);
    }

    /**
     * @param string $name
     * @return NamedObjectInterface
     * @throws ArgumentTypeException
     */
    public function get($name)
    {
        if (ObjectHelper::isValidArgumentType($name, [ObjectHelper::STRING])) {
            if (isset($this->objects[$name])) {
                return $this->objects[$name];
            }

            return null;
        }

        throw new ArgumentTypeException('name', [ObjectHelper::STRING], $name);
    }

    /**
     * @param NamedObjectInterface $pair
     * @throws \Exception
     * @return ObjectList
     */
    public function add($pair)
    {
        if (ObjectHelper::isValidElementTypes($pair, $this->elementClasses)) {
            $this->objects[$pair->getName()] = $pair;

            return $this;
        }
        throw new ArgumentTypeException('pair', $this->elementClasses, $pair);
    }

    /**
     * @return NamedObjectInterface[]
     */
    public function getAll()
    {
        return $this->objects;
    }

    /**
     * @param string $name
     * @return $this
     * @throws ArgumentTypeException
     */
    public function delete($name)
    {
        if (ObjectHelper::isValidArgumentType($name, [ObjectHelper::STRING])) {
            if (isset($this->objects[$name])) {
                unset($this->objects[$name]);

                return $this;
            }
        }

        throw new ArgumentTypeException('name', [ObjectHelper::STRING], $name);
    }

    /**
     * @param NamedObjectInterface[] $pairs
     * @throws \Exception
     * @return ObjectList
     */
    public function addArray(array $pairs)
    {
        foreach ($pairs as $pair) {
            $this->add($pair);
        }

        return $this;
    }

    public function rewind()
    {
        reset($this->objects);
    }

    public function current()
    {
        $var = current($this->objects);

        return $var;
    }

    public function key()
    {
        $var = key($this->objects);

        return $var;
    }

    public function next()
    {
        $var = next($this->objects);

        return $var;
    }

    public function valid()
    {
        $key = key($this->objects);
        $var = ($key !== null && $key !== false);

        return $var;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        return implode($this->objectsDelimiter, $this->objects);
    }

    public function toArray()
    {
        $res = [];
        foreach($this->getAll() as $name => $obj){
            $res[$name] = $obj->toArray();
        }

        return $res;
    }
}