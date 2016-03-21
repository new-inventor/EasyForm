<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:46
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Interfaces\ObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;

class ObjectList extends Object implements \Iterator, ObjectListInterface
{
    /** @var mixed[] */
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
        TypeChecker::getInstance()
            ->checkArray($elementClasses, [SimpleTypes::STRING], 'elementClasses')
            ->throwCustomErrorIfNotValid('Переданы  неправильные классы');
        $this->elementClasses = $elementClasses;

        return $this;
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
        TypeChecker::getInstance()
            ->check($index, [SimpleTypes::INT, SimpleTypes::STRING], 'index')
            ->throwTypeErrorIfNotValid();
        if (array_key_exists($index, $this->objects)) {
            return $this->objects[$index];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function add($object)
    {
        TypeChecker::getInstance()
            ->check($object, $this->getElementClasses(), 'object')
            ->throwTypeErrorIfNotValid();
        $this->objects[] = $object;

        return $this;
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
        TypeChecker::getInstance()
            ->check($index, [SimpleTypes::INT, SimpleTypes::STRING], 'index')
            ->throwTypeErrorIfNotValid();
        if (isset($this->objects[$index])) {
            unset($this->objects[$index]);
        }

        return $this;
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
        if (isset($data['elementClasses'])) {
            $list->setElementClasses($data['elementClasses']);
        }
        if (isset($data['objects'])) {
            $list->addArray($data['objects']);
        }

        return $list;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->objects);
    }
}