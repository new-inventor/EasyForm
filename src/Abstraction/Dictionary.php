<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:35
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Interfaces\NamedObjectInterface;

class Dictionary implements \Iterator
{
    /** @var array */
    private $pairs;
    /** @var string */
    private $pairDelimiter;
    /** @var string */
    private $elementClass;

    /**
     * Dictionary constructor.
     * @param string $elementClass
     */
    public function __construct($elementClass)
    {
        $this->elementClass = $elementClass;
    }

    /**
     * @return string
     */
    public function getPairDelimiter()
    {
        return $this->pairDelimiter;
    }

    /**
     * @param string $pairDelimiter
     * @return Dictionary
     */
    public function setPairDelimiter($pairDelimiter)
    {
        $this->pairDelimiter = (string)$pairDelimiter;

        return $this;
    }

    /**
     * @param string $name
     * @return NamedObjectInterface
     */
    public function get($name)
    {
        $name = (string)$name;
        return $this->pairs[$name];
    }

    /**
     * @param NamedObjectInterface $pair
     * @throws \Exception
     * @return Dictionary
     */
    public function add($pair)
    {
        if(!is_a($pair, $this->elementClass)){
            throw new \Exception('Parameter does not match elements class.');
        }
        $this->pairs[$pair->getName()] = $pair;

        return $this;
    }

    /**
     * @return NamedObjectInterface[]
     */
    public function getAll()
    {
        return $this->pairs;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete($name)
    {
        $name = (string)$name;
        if (isset($this->pairs[$name])) {
            unset($this->pairs[$name]);
            return true;
        }
        return false;
    }

    /**
     * @param NamedObjectInterface[] $pairs
     * @throws \Exception
     * @return Dictionary
     */
    public function addArray(array $pairs)
    {
        foreach($pairs as $pair){
            if(is_a($pair, $this->elementClass)){
                $this->pairs[$pair->getName()] = $pair;
            }else{
                throw new \Exception('Type' . get_class($pair) . ' does not supported');
            }
        }

        return $this;
    }

    public function rewind()
    {
        reset($this->pairs);
    }

    public function current()
    {
        $var = current($this->pairs);
        return $var;
    }

    public function key()
    {
        $var = key($this->pairs);
        return $var;
    }

    public function next()
    {
        $var = next($this->pairs);
        return $var;
    }

    public function valid()
    {
        $key = key($this->pairs);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function __toString()
    {
        return $this->getString();
    }

    public function getString()
    {
        return implode($this->pairDelimiter, $this->pairs);
    }
}