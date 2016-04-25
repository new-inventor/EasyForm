<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 13:57
 */

namespace NewInventor\Form\Validator\Exceptions;


use NewInventor\Template\Template;
use NewInventor\TypeChecker\TypeChecker;

class Base extends \Exception
{
    private $objectName = '';

    /**
     * Base constructor.
     * @param string $objectName
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($objectName, $message = '', $code = 0, $previous = null)
    {
        $this->setObjectName($objectName);

        parent::__construct($this->getMessageString($message), $code, $previous);
    }
    
    protected function setObjectName($objectName)
    {
        TypeChecker::getInstance()
            ->isString($objectName, 'objectName')
            ->throwTypeErrorIfNotValid();
        $this->objectName = $objectName;
    }

    protected function getMessageString($message)
    {
        TypeChecker::getInstance()
            ->isString($message, 'message')
            ->throwTypeErrorIfNotValid();
        if (empty($message)) {
            $message = $this->getDefaultMessage();
        }

        return $this->processMessageTemplate($message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" не верно.';
    }

    protected function processMessageTemplate($messageTemplate)
    {
        $template = new Template($messageTemplate);

        return $template->getString($this);
    }

    public function n()
    {
        return (string)$this->objectName;
    }
}