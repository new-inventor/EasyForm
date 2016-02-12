<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 17:51
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Interfaces\NamedObjectInterface;

class NamedObject implements NamedObjectInterface
{
    /** @var string */
    private $name;

    /**
     * NamedObject constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     * @throws \Exception
     */
    public function setName($name)
    {
        if(is_string($name)){
            $this->name = $name;
        }else{
            throw new \Exception('Name is not a string');
        }

        return $this;
    }

    public static function initFromArray(array $data)
    {
        if(isset($data['name'])){
            return new static($data['name']);
        }
        throw new \Exception('Name does not defined');
    }

    public function toArray()
    {
        return [
            'name' => $this->getName()
        ];
    }

    public function __toString(){
        return $this->getName();
    }

    public static function getClass()
    {
        return get_called_class();
    }
}