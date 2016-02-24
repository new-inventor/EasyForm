<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Abstraction\NamedObjectList;
use NewInventor\EasyForm\Handler\AbstractHandler;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Field\AbstractField;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FormInterface;
use NewInventor\EasyForm\Interfaces\HandlerInterface;

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

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /** @var string */
    private $method;
    /** @var string */
    private $action;
    /** @var string */
    private $encType;
    /** @var NamedObjectList */
    private $handlers;

    /**
     * AbstractForm constructor.
     *
     * @param string $name
     * @param string $title
     * @param string $action
     * @param string $method
     * @param string $encType
     *
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function __construct($name, $action = '', $method = 'post', $title = '', $encType = self::ENC_TYPE_URLENCODED)
    {
        parent::__construct($name, $title, false);
        if (!is_null($action)) {
            $this->action($action);
        }
        if (!is_null($method)) {
            $this->method($method);
        }
        if (!is_null($encType)) {
            $this->encType($encType);
        }
        $this->handlers = new NamedObjectList();
        $this->handlers->setElementClasses([AbstractHandler::getClass()]);
        $this->children()->setElementClasses([AbstractBlock::getClass(), AbstractField::getClass()]);
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
     *
     * @return $this
     * @throws ArgumentTypeException
     */
    public function method($method)
    {
        if (ObjectHelper::isValidType($method, [ObjectHelper::STRING])) {
            $this->method = $method;
            $this->attributes()->add(HtmlAttr::build('method', $method)->full());

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
     *
     * @return $this
     * @throws ArgumentTypeException
     */
    public function action($action)
    {
        if (ObjectHelper::isValidType($action, [ObjectHelper::STRING])) {
            $this->action = $action;
            $this->attributes()->add(HtmlAttr::build('action', $action)->full());

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
     *
     * @return $this
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function encType($encType)
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

    public function getString()
    {
        $form = '<form name="' . $this->getFullName() . '" ' . $this->attributes() . '>';
        $form .= $this->children();
        $form .= $this->handlers();
        $form .= '</form>';

        return $form;
    }

    /**
     * @return NamedObjectList
     */
    public function handlers()
    {
        return $this->handlers;
    }

    /**
     * @param string $handler Handler type
     *
     * @return FormInterface
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function handler($handler)
    {
        if(!class_exists($handler) && $handler instanceof HandlerInterface) {
            throw new ArgumentException('Класс обработчика формы не существует.', 'handler');
        }
        /** @var HandlerInterface $handler */
        $handler = new $handler($this);
        $this->handlers()->add($handler);

        return $this;
    }

    /**
     * @param array|null $customData
     *
     * @return bool
     */
    public function save(array $customData = null)
    {

        $data = $customData;
        if($data === null && isset($_REQUEST[$this->getName()])){
            $data = $_REQUEST[$this->getName()];
        }
        if($data === null){
            return false;
        }
        /**
         * @var string $key
         * @var HandlerInterface $handler
         */
        foreach($this->handlers() as $key => $handler){
            if(array_key_exists($key, $data)){
                return $handler->process();
            }
        }
        return false;
    }
}