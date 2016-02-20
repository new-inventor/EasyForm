<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FormInterface;

class AbstractForm extends AbstractBlock implements FormInterface
{
    const ENC_TYPE_URLENCODED = 'urlencoded';
    const ENC_TYPE_MULTIPART = 'multipart';
    const ENC_TYPE_PLAIN = 'plain';

    private $encTypes = [
        'urlencoded' => 'application/x-www-form-urlencoded',
        'multipart' => 'multipart/form-data',
        'plain' => 'text/plain'
    ];

    /** @var string */
    private $method;
    /** @var string */
    private $action;
    /** @var string */
    private $encType;

    /**
     * AbstractForm constructor.
     * @param string $name
     * @param string $title
     * @param string $action
     * @param string $method
     * @param string $encType
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function __construct($name, $title, $action = '', $method = 'post', $encType = self::ENC_TYPE_URLENCODED)
    {
        parent::__construct($name, $title, false);
        $this->attributes()->add(HtmlAttr::build('action', $action)->full());
        $this->attributes()->add(HtmlAttr::build('method', $method)->full());
        if (ObjectHelper::isValidType($encType, [ObjectHelper::STRING])) {
            if (!array_key_exists($encType, $this->encTypes)) {
                throw new ArgumentException('Кодировка формы должна быть "', implode('" или "', $this->encTypes) . '".', 'encType');
            }
            $this->attributes()->add(HtmlAttr::build('enctype', $encType)->full());
        }else{
            throw new ArgumentTypeException('encType', [ObjectHelper::STRING], $encType);
        }
        $this->children()->setElementClasses([AbstractBlock::getClass(), AbstractInputField::getClass()]);
    }

    public function isValidEncType($encType)
    {
        return ($encType == self::ENC_TYPE_URLENCODED) ||
        ($encType == self::ENC_TYPE_MULTIPART) ||
        ($encType == self::ENC_TYPE_PLAIN);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setMethod($method)
    {
        if (ObjectHelper::isValidType($method, [ObjectHelper::STRING])) {
            $this->method = $method;

            return $this;
        }
        throw new ArgumentTypeException('method', [ObjectHelper::STRING], $method);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setAction($action)
    {
        if (ObjectHelper::isValidType($action, [ObjectHelper::STRING])) {
            $this->action = $action;

            return $this;
        }
        throw new ArgumentTypeException('action', [ObjectHelper::STRING], $action);
    }

    /**
     * @return string
     */
    public function getEncType()
    {
        return $this->encType;
    }

    /**
     * @param string $encType
     * @return $this
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function setEncType($encType)
    {
        if (ObjectHelper::isValidType($encType, [ObjectHelper::STRING])) {
            if (array_key_exists($encType, $this->encTypes)) {
                $this->encType = $encType;

                return $this;
            }
            throw new ArgumentException('Кодировка формы должна быть "', implode('" или "', $this->encTypes) . '".', 'encType');
        }
        throw new ArgumentTypeException('encType', [ObjectHelper::STRING], $encType);
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res['method'] = $this->getMethod();
        $res['action'] = $this->getAction();
        $res['encType'] = $this->getEncType();
    }



    public function tab()
    {
        // TODO: Implement tab() method.
    }

    public function repeatableBlock()
    {
        // TODO: Implement repeatedBlock() method.
    }

    public function repeatableField()
    {
        // TODO: Implement repeatedField() method.
    }
}