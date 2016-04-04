<?php

namespace NewInventor\Form;

use NewInventor\Abstractions\NamedObjectList;
use NewInventor\Form\Abstraction\HtmlAttr;
use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Field\AbstractField;
use NewInventor\Form\Handler\AbstractHandler;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Interfaces\HandlerInterface;
use NewInventor\Form\Renderer\FormRenderer;
use NewInventor\Form\Renderer\RendererInterface;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

class Form extends Block implements FormInterface
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
    public function __construct(
        $name,
        $action = '',
        $method = 'post',
        $title = '',
        $encType = self::ENC_TYPE_URLENCODED
    ) {
        parent::__construct($name, $title);
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
        $this->children()->setElementClasses([Block::getClass(), AbstractField::getClass()]);
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
        TypeChecker::getInstance()
            ->isString($method, 'method')
            ->throwTypeErrorIfNotValid();
        $this->method = $method;
        $this->attributes()->add(new KeyValuePair('method', $method));

        return $this;
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
        TypeChecker::getInstance()
            ->isString($action, 'action')
            ->throwTypeErrorIfNotValid();
        $this->action = $action;
        $this->attributes()->add(HtmlAttr::build('action', $action)->full());

        return $this;
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
        TypeChecker::getInstance()
            ->isString($encType, 'encType')
            ->throwTypeErrorIfNotValid();
        if (array_key_exists($encType, $this->encTypes)) {
            $this->encType = $encType;

            return $this;
        }
        throw new ArgumentException('Кодировка формы должна быть "', implode('" или "', $this->encTypes) . '".',
            'encType');
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res['method'] = $this->getMethod();
        $res['action'] = $this->getAction();
        $res['encType'] = $this->getEncType();
    }

    /**
     * @return NamedObjectList
     */
    public function handlers()
    {
        return $this->handlers;
    }

    /**
     * @param string|\Closure|HandlerInterface $handler Handler type
     * @param string                           $name
     * @param string                           $value
     *
     * @return FormInterface
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function handler($handler, $name = 'abstractHandler', $value = 'Абстрактное действие')
    {
        if (!class_exists($handler) && !($handler instanceof HandlerInterface) && !($handler instanceof \Closure)) {
            throw new ArgumentException('Класс обработчика формы не существует.', 'handler');
        }
        if (is_string($handler)) {
            /** @var HandlerInterface $handler */
            $handler = new $handler($this, $name, $value);
        } elseif ($handler instanceof \Closure) {
            $handler = new AbstractHandler($this, $name, $value, $handler);
        }
        $this->handlers()->add($handler);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getString()
    {
        $renderer = new FormRenderer();
        return $renderer->render($this);
    }

    /**
     * @param array|null $customData
     *
     * @return bool
     */
    public function save(array $customData = null)
    {
        $data = $customData;
        if ($data === null && isset($_REQUEST[$this->getName()])) {
            $data = $_REQUEST[$this->getName()];
        }
        if ($data === null) {
            return false;
        }
        /**
         * @var string $key
         * @var HandlerInterface $handler
         */
        foreach ($this->handlers() as $key => $handler) {
            if (array_key_exists($key, $data)) {
                return $handler->process();
            }
        }

        return false;
    }
}