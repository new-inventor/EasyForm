<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 17:51
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\NamedObjectInterface;

class NamedObject extends Object implements NamedObjectInterface
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
     * @throws ArgumentTypeException
     */
    public function setName($name)
    {
        if (ObjectHelper::isValidType($name, [ObjectHelper::STRING])) {
            $this->name = $name;

            return $this;
        }
        throw new ArgumentTypeException('name', [ObjectHelper::STRING], $name);
    }

    public static function initFromArray(array $data)
    {
        if (isset($data['name'])) {
            return new static($data['name']);
        }
        throw new ArgumentException('Имя не передано.', 'data');
    }

    public function toArray()
    {
        return [
            'name' => $this->getName()
        ];
    }

    public static function getClass()
    {
        return get_called_class();
    }
}