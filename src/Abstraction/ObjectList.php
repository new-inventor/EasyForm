<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:46
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ArrayHelper;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\ObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;

class ObjectList extends Object implements \Iterator, ObjectListInterface
{
    /** @var ObjectInterface[] */
    protected $objects;
    /** @var string */
    private $elementClasses;

    public function __construct(array $elementClasses = [])
    {
        $this->objects = [];
        $this->setElementClasses($elementClasses);
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getElementClasses()
    {
        return $this->elementClasses;
    }

    /**
     * @inheritdoc
     */
    public function get($index)
    {
        if (ObjectHelper::isValidType($index, [ObjectHelper::INT, ObjectHelper::STRING])) {
            if (isset($this->objects[$index])) {
                return $this->objects[$index];
            }

            return null;
        }

        throw new ArgumentTypeException('index', [ObjectHelper::INT, ObjectHelper::STRING], $index);
    }

    /**
     * @inheritdoc
     */
    public function add($object)
    {
        if (ObjectHelper::isValidType($object, $this->getElementClasses())) {
            $this->objects[] = $object;

            return $this;
        }
        throw new ArgumentTypeException('object', $this->getElementClasses(), $object);
    }

    /**
     * @inheritdoc
     */
    public function getAll()
    {
        return $this->objects;
    }

    /**
     * @inheritdoc
     */
    public function delete($index)
    {
        if (ObjectHelper::isValidType($index, [ObjectHelper::INT, ObjectHelper::STRING])) {
            if (isset($this->objects[$index])) {
                unset($this->objects[$index]);

                return $this;
            }
        }

        throw new ArgumentTypeException('index', [ObjectHelper::INT], $index);
    }

    /**
     * @inheritdoc
     */
    public function addArray(array $objects)
    {
        foreach ($objects as $object) {
            $this->add($object);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $res = [];
        /** @var ObjectInterface $obj */
        foreach ($this->getAll() as $obj) {
            $res[] = $obj->toArray();
        }

        return $res;
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

    public static function initFromArray(array $data)
    {
        $list = new static();
        if(isset($data['elementClasses'])){
            $list->setElementClasses($data['elementClasses']);
        }
        if(isset($data['objects'])){
            $list->addArray($data['objects']);
        }

        return $list;
    }
}