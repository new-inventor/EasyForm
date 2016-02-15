<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:21
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Helper\ObjectHelper;

class KeyValuePair extends NamedObject
{
    use FieldValidatorTrait;

    /** @var string */
    private $value;
    /** @var string */
    private $delimiter;
    /** @var string */
    private $nameComaLeft;
    /** @var string */
    private $nameComaRight;
    /** @var string */
    private $valueComaLeft;
    /** @var string */
    private $valueComaRight;
    /** @var bool */
    private $canBeShort;

    /**
     * KeyValuePair constructor.
     * @param string $name
     * @param string $value
     * @param bool $canBeShort
     */
    public function __construct($name, $value = '', $canBeShort = false)
    {
        parent::__construct($name);
        $this->setValue($value);
        $this->setCanBeShort($canBeShort);
        $this->setDelimiter('');
        $this->setNameComas('', '');
        $this->setValueComas('', '');
    }

    /**
     * @return boolean
     */
    public function isCanBeShort()
    {
        return $this->canBeShort;
    }

    /**
     * @param bool $canBeShort
     * @return $this
     * @throws \Exception
     */
    public function setCanBeShort($canBeShort)
    {
        return $this->setField('canBeShort', $canBeShort, [ObjectHelper::BOOL]);
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
     * @return $this
     * @throws \Exception
     */
    public function setValue($value)
    {
        return $this->setField('value', $value, [ObjectHelper::STRING]);
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return $this
     * @throws \Exception
     */
    public function setDelimiter($delimiter)
    {
        return $this->setField('delimiter', $delimiter, [ObjectHelper::STRING]);

        return $this;
    }

    /**
     * @return array [left, right]
     */
    public function getNameComas()
    {
        return [$this->nameComaLeft, $this->nameComaRight];
    }

    /**
     * @param string $nameComaLeft
     * @param string $nameComaRight
     * @return KeyValuePair
     */
    public function setNameComas($nameComaLeft, $nameComaRight = null)
    {
        if(!isset($nameComaRight)){
            $nameComaRight = $nameComaLeft;
        }
        $this->setComasArray('name', [$nameComaLeft, $nameComaRight]);

        return $this;
    }

    /**
     * @return array [left, right]
     */
    public function getValueComas()
    {
        return [$this->valueComaLeft, $this->valueComaRight];
    }

    /**
     * @param $valueComaLeft
     * @param $valueComaRight
     * @return KeyValuePair
     */
    public function setValueComas($valueComaLeft, $valueComaRight = null)
    {
        if(!isset($valueComaRight)){
            $valueComaRight = $valueComaLeft;
        }
        $this->setComasArray('value', [$valueComaLeft, $valueComaRight]);

        return $this;
    }

    public function __toString()
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    public function getString()
    {
        $nameComas = $this->getNameComas();
        $res = $nameComas['left'] . $this->getName() . $nameComas['right'];
        if($this->isCanBeShort() && $this->isValueEmpty()){
            return $res;
        }
        $valueComas = $this->getValueComas();
        $res .= $this->getDelimiter() . $valueComas['left'] . $this->getValue() . $valueComas['right'];

        return $res;
    }

    public function isValueEmpty()
    {
        return empty($this->value);
    }

    /**
     * @param array $data
     * @return KeyValuePair
     * @throws \Exception
     */
    public static function initFromArray(array $data)
    {
        if(!isset($data['name'])){
            throw new \Exception('Name must be specified.');
        }
        $pair = new KeyValuePair($data['name']);
        if(isset($data['value'])){
            $pair->setValue((string)$data['value']);
        }
        if(isset($data['canBeShort'])){
            $pair->setCanBeShort((bool)$data['canBeShort']);
        }
        if(isset($data['delimiter'])){
            $pair->setDelimiter((string)$data['delimiter']);
        }
        if(isset($data['valueComas'])){
            $pair->setComasArray('value', $data['valueComas']);
        }
        if(isset($data['nameComas'])){
            $pair->setComasArray('name', $data['nameComas']);
        }

        return $pair;
    }

    public static function isArrayParamsValid($params){
        if(!isset($params['name']) || isset($params['name']) && !is_string($params['name'])){
            return false;
        }
        if(isset($params['value']) && !is_string($params['value'])){
            return false;
        }
        if(isset($params['delimiter']) && !is_string($params['delimiter'])){
            return false;
        }
        if(isset($params['canBeShort']) && !is_bool($params['canBeShort'])){
            return false;
        }
        if(isset($params['valueComas']) && !self::isValidComasArray($params['valueComas'])){
            return false;
        }
        if(isset($params['nameComas']) && !self::isValidComasArray($params['nameComas'])){
            return false;
        }
        return true;
    }

    public static function isValidComasArray($comas)
    {
        if((!is_array($comas) || count($comas) < 1 || count($comas) > 2 ||
            (count($comas) > 0 && !is_string($comas[0])) ||
            (count($comas) > 1 && !is_string($comas[1]))) &&
            !is_string($comas)
        ){
            return false;
        }
        return true;
    }

    public function setComasArray($kind, $data)
    {
        if(!self::isValidComasArray($data)){
            throw new \Exception('Not correct format of comas');
        }
        $method = $this->getMethod($kind);
        if(is_array($data) && count($data) == 1){
            $this->$method($data[0]);
        }elseif(is_array($data) && count($data) == 2){
            $this->$method($data[0], $data[1]);
        }elseif(is_string($data)){
            $this->$method($data);
        }else{
            throw new \Exception('Not correct format of comas');
        }

        return $this;
    }

    protected function getMethod($kind)
    {
        $method = 'set' . ucfirst($kind) . 'Comas';
        if(in_array($method, get_class_methods(get_class($this)))){
            return $method;
        }

        throw new \Exception('Not correct comas kind.');
    }
}