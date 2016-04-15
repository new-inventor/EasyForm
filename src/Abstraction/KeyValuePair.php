<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:21
 */

namespace NewInventor\Form\Abstraction;


use NewInventor\Abstractions\NamedObject;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\SimpleTypes;
use NewInventor\TypeChecker\TypeChecker;

class KeyValuePair extends NamedObject
{
    /** @var string */
    private $value;
    /** @var bool */
    private $canBeShort;
    
    /**
     * KeyValuePair constructor.
     *
     * @param string $name
     * @param string $value
     * @param bool $canBeShort
     */
    public function __construct($name, $value = '', $canBeShort = false)
    {
        parent::__construct($name);
        $this->setValue($value);
        $this->setCanBeShort($canBeShort);
    }
    
    /**
     * @return boolean
     */
    public function isCanBeShort()
    {
        return $this->canBeShort;
    }
    
    public function short()
    {
        $this->canBeShort = true;
        
        return $this;
    }
    
    public function full()
    {
        $this->canBeShort = false;
        
        return $this;
    }
    
    /**
     * @param bool $canBeShort
     *
     * @return $this
     * @throws \Exception
     */
    public function setCanBeShort($canBeShort)
    {
        $typeChecker = TypeChecker::getInstance();
        if (!$typeChecker->isBool($canBeShort, 'canBeShort')) {
            $typeChecker->throwTypeError();
        }
        $this->canBeShort = $canBeShort;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @param string $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setValue($value)
    {
        $typeChecker = TypeChecker::getInstance();
        if (!$typeChecker->check($value, [SimpleTypes::STRING, SimpleTypes::INT, SimpleTypes::FLOAT, SimpleTypes::NULL],
            'value')
        ) {
            $typeChecker->throwTypeError();
        }
        $this->value = $value;
        
        return $this;
    }
    
    public function __toString()
    {
        return $this->getString();
    }
    
    public function getString()
    {
        $res = '';
        return $res;
    }
    
    /**
     * @return string
     */
    public function render()
    {
        echo $this->getString();
    }
    
    public function isValueEmpty()
    {
        return empty($this->value);
    }
    
    /**
     * @param array $data
     *
     * @return KeyValuePair
     * @throws ArgumentException
     */
    public static function initFromArray(array $data)
    {
        if (!isset($data['name'])) {
            throw new ArgumentException('Имя должно быть заполнено.');
        }
        
        $pair = new KeyValuePair($data['name']);
        if (isset($data['value'])) {
            $pair->setValue((string)$data['value']);
        }
        if (isset($data['canBeShort'])) {
            $pair->setCanBeShort((bool)$data['canBeShort']);
        }
        
        return $pair;
    }
    
    public static function isArrayParamsValid($params)
    {
        if (!isset($params['name']) || isset($params['name']) && !is_string($params['name'])) {
            return false;
        }
        if (isset($params['value']) && !is_string($params['value'])) {
            return false;
        }
        if (isset($params['canBeShort']) && !is_bool($params['canBeShort'])) {
            return false;
        }
        
        return true;
    }
}