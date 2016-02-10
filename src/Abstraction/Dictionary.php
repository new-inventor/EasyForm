<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:35
 */

namespace NewInventor\EasyForm\Abstraction;

class Dictionary implements \Iterator
{
    /** @var  KeyValuePair[] */
    private $pairs;

    /**
     * Dictionary constructor.
     * @param KeyValuePair[]|array $pairs
     */
    public function __construct(array $pairs)
    {
        $this->addFromArray($pairs);
    }

    /**
     * @param string $name
     * @return KeyValuePair
     */
    public function get($name)
    {
        $name = (string)$name;
        return $this->pairs[$name];
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function add($name, $value)
    {
        $name = (string)$name;
        $value = (string)$value;
        $this->pairs[$name] = $value;
    }

    /**
     * @return KeyValuePair[]
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
     * @param array $pairs
     */
    public function addFromArray(array $pairs)
    {
        foreach($pairs as $key => $pair){
            if($pair instanceof KeyValuePair){
                $this->pairs[$pair->getName()] = $pair;
            }else{
                $this->pairs[$key] = new KeyValuePair($key, $pair['value'], $pair['canBeShort']);
                $this->pairs[$key]->setDelimiter($pair['delimiter']);
                $this->pairs[$key]->setNameComas($pair['nameComas'][0], $pair['valueComas'][1]);
                $this->pairs[$key]->setValueComas($pair['valueComas'][0], $pair['valueComas'][1]);
            }
        }
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
}