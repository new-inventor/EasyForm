<?php

namespace NewInventor\Form\Interfaces;


use NewInventor\Abstractions\NamedObjectList;
use NewInventor\Form\Exceptions\SessionException;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

interface FormInterface extends BlockInterface
{
    
    /**
     * @param string $encType
     *
     * @return bool
     */
    public function isValidEncType($encType);
    
    /**
     * @return string
     */
    public function getMethod();
    
    /**
     * @param string $method
     *
     * @return FormInterface
     * @throws ArgumentTypeException
     */
    public function method($method);
    
    /**
     * @return string
     */
    public function getAction();
    
    /**
     * @param string $action
     *
     * @return FormInterface
     * @throws ArgumentTypeException
     */
    public function action($action);
    
    /**
     * @return string
     */
    public function getEncType();
    
    /**
     * @param string $encType
     *
     * @return FormInterface
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function encType($encType);
    
    /**
     * @return NamedObjectList
     */
    public function handlers();
    
    /**
     * @param callable|\Closure|HandlerInterface $handler Handler type
     * @param string $name
     * @param string $value
     *
     * @return FormInterface
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function handler($handler, $name = 'abstract', $value = 'Абстрактное действие');
    
    /**
     * @param array|null $customData
     *
     * @return bool
     */
    public function save(array $customData = null);
    
    
    /**
     * @return FormInterface
     */
    public function loadJQuery();
    
    /**
     * @return bool
     */
    public function showJQuery();
    
    /**
     * @return string
     */
    public function getSuccessMessage();
    
    /**
     * @param $message
     * @throws ArgumentTypeException
     * @return FormInterface
     */
    public function successMessage($message);
    
    /**
     * @return string
     */
    public function getFailMessage();
    
    /**
     * @param $message
     * @throws ArgumentTypeException
     * @return FormInterface
     */
    public function failMessage($message);
    
    /**
     * @return array
     * @throws SessionException
     */
    public function getSessionData();
    
    /**
     * @param $data
     * @throws SessionException
     */
    public function setSessionData($data);
    
    /**
     * @return mixed
     * @throws SessionException
     */
    public function getStatus();
    
    /**
     * @param $status
     * @throws SessionException
     */
    public function setStatus($status);
    
    /**
     * @return array
     */
    public function getResult();

    /**
     * @param array $result
     */
    public function setResult(array $result);
}