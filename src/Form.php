<?php

namespace NewInventor\Form;

use NewInventor\Abstractions\NamedObjectList;
use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Exceptions\SessionException;
use NewInventor\Form\Field\AbstractField;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Interfaces\HandlerInterface;
use NewInventor\Form\Renderer\FormRenderer;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

//TODO сделать настраиваемое положение ошибок
//TODO AJAX send(by change, by submit)
//TODO user validation (one by one + full form + pre send)
//TODO creation from array
//TODO multi step forms
//TODO from and to object translators
//TODO check security
//TODO fill up the field types(captcha, date picker, file preview, file drop down, rating, code, html, range, geo map, ...)
//TODO some custom patterns
//TODO translate to php 7
//TODO change validators (elements relations) and translate to separate project. Fill up validators
//TODO i18n internationalisation
//TODO Increase work speed

class Form extends Block implements FormInterface
{
    const ENC_TYPE_URLENCODED = 'urlencoded';
    const ENC_TYPE_MULTIPART = 'multipart';
    const ENC_TYPE_PLAIN = 'plain';
    
    const STATUS_NORMAL = 0;
    const STATUS_BEFORE_REDIRECT = 1;
    const STATUS_SHOW_RESULT = 2;
    
    private $encTypes = [
        'urlencoded' => 'application/x-www-form-urlencoded',
        'multipart'  => 'multipart/form-data',
        'plain'      => 'text/plain'
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
    /** @var string */
    private $successMessage = '';
    /** @var string */
    private $failMessage = '';
    /** @var bool */
    private $loadJQuery = false;
    
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
        $this->handlers->setElementClasses(['NewInventor\Form\Interfaces\HandlerInterface']);
        $this->children()->setElementClasses([Block::getClass(), AbstractField::getClass()]);
    }
    
    /**
     * @inheritdoc
     */
    public function isValidEncType($encType)
    {
        return ($encType == self::ENC_TYPE_URLENCODED) ||
        ($encType == self::ENC_TYPE_MULTIPART) ||
        ($encType == self::ENC_TYPE_PLAIN);
    }
    
    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @inheritdoc
     */
    public function action($action)
    {
        TypeChecker::getInstance()
            ->isString($action, 'action')
            ->throwTypeErrorIfNotValid();
        $this->action = $action;
        $this->attributes()->add(new KeyValuePair('action', $action));
        
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getEncType()
    {
        return $this->encType;
    }
    
    /**
     * @inheritdoc
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
    
    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $res = parent::toArray();
        $res['method'] = $this->getMethod();
        $res['action'] = $this->getAction();
        $res['encType'] = $this->getEncType();
        
        return $res;
    }
    
    /**
     * @inheritdoc
     */
    public function handlers()
    {
        return $this->handlers;
    }
    
    /**
     * @inheritdoc
     */
    public function handler($handler, $name = 'abstract', $value = 'Абстрактное действие')
    {
        if ($handler instanceof HandlerInterface) {
            $handler->setName($name);
            $handler->title($value);
            $handler->attribute('value', $value);
            $this->handlers()->add($handler);
        } else {
            $handler = new Handler($this, $handler, $name, $value);
            $this->handlers()->add($handler);
        }
        
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
     * @inheritdoc
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
        if(!$this->validate()){
            return false;
        }
        /**
         * @var string $key
         * @var HandlerInterface $handler
         */
        foreach ($this->handlers() as $key => $handler) {
            if (array_key_exists($key, $data)) {
                $result = $handler->process();
                if ($result) {
                    $this->afterSave();
                }else{
                    $this->addError($this->getFailMessage());
                }
                return $result;
            }
        }
        
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function load($data = null)
    {
        $status = $this->getStatus();
        if ($status == self::STATUS_SHOW_RESULT || $status == self::STATUS_NORMAL) {
            $this->beforeSave();
        }
        if ($status == self::STATUS_BEFORE_REDIRECT) {
            $this->afterRefresh();
        }
        return parent::load($data);
    }
    
    protected function afterSave()
    {
        $this->setStatus(self::STATUS_BEFORE_REDIRECT);
        if($this->method == self::METHOD_POST) {
            header("Refresh:0");
        }
    }
    
    protected function beforeSave()
    {
        $this->setStatus(self::STATUS_NORMAL);
    }
    
    protected function afterRefresh()
    {
        $this->setStatus(self::STATUS_SHOW_RESULT);
    }
    
    /**
     * @inheritdoc
     */
    public function getSessionData()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new SessionException('Для использования формы необходимо проинициализировать сессию.');
        }
        if (isset($_SESSION['forms'][$this->getName()])) {
            return $_SESSION['forms'][$this->getName()];
        }
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public function setSessionData($data)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new SessionException('Для использования формы необходимо проинициализировать сессию.');
        }
        $_SESSION['forms'][$this->getName()] = $data;
    }
    
    /**
     * @inheritdoc
     */
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }
    
    /**
     * @inheritdoc
     */
    public function successMessage($message)
    {
        TypeChecker::getInstance()
            ->isString($message, 'message')
            ->throwTypeErrorIfNotValid();
        
        $this->successMessage = $message;
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getFailMessage()
    {
        return $this->failMessage;
    }
    
    /**
     * @inheritdoc
     */
    public function failMessage($message)
    {
        TypeChecker::getInstance()
            ->isString($message, 'message')
            ->throwTypeErrorIfNotValid();
        
        $this->failMessage = $message;
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        $sessionData = $this->getSessionData();
        if (isset($sessionData['status'])) {
            return $sessionData['status'];
        }
        return 0;
    }
    
    /**
     * @inheritdoc
     */
    public function setStatus($status)
    {
        TypeChecker::getInstance()
            ->isInt($status, 'status')
            ->throwTypeErrorIfNotValid();
        
        $sessionData = $this->getSessionData();
        $sessionData['status'] = $status;
        $this->setSessionData($sessionData);
    }
    
    /**
     * @inheritdoc
     */
    public function loadJQuery()
    {
        $this->loadJQuery = true;
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function showJQuery()
    {
        return $this->loadJQuery;
    }
}