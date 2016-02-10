<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:21
 */

namespace NewInventor\EasyForm\Abstraction;

class KeyValuePair
{
    /** @var string */
    private $name;
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
        $this->setName($name);
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
     * @param boolean $canBeShort
     */
    public function setCanBeShort($canBeShort)
    {
        $this->canBeShort = (bool)$canBeShort;
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
     */
    public function setName($name)
    {
        $this->name = (string)$name;
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
     */
    public function setValue($value)
    {
        $this->value = (string)$value;
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
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = (string)$delimiter;
    }

    /**
     * @return string
     */
    public function getNameComas()
    {
        return ['left' => $this->nameComaLeft, 'right' => $this->nameComaRight];
    }

    /**
     * @param string $nameComaLeft
     * @param string $nameComaRight
     */
    public function setNameComas($nameComaLeft, $nameComaRight = null)
    {
        if(!isset($nameComaRight)){
            $nameComaRight = $nameComaLeft;
        }
        $this->nameComaLeft = (string)$nameComaLeft;
        $this->nameComaRight = (string)$nameComaRight;
    }

    /**
     * @return string
     */
    public function getValueComas()
    {
        return ['left' => $this->valueComaLeft, 'right' => $this->valueComaRight];
    }

    /**
     * @param $valueComaLeft
     * @param $valueComaRight
     */
    public function setValueComas($valueComaLeft, $valueComaRight = null)
    {
        if(!isset($valueComaRight)){
            $valueComaRight = $valueComaLeft;
        }
        $this->valueComaLeft = (string)$valueComaLeft;
        $this->valueComaRight = (string)$valueComaRight;
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
}