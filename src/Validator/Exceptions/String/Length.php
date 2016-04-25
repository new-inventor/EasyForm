<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 16:51
 */

namespace NewInventor\Form\Validator\Exceptions\String;


use NewInventor\TypeChecker\TypeChecker;

class Length extends Base
{
    protected $length;
    
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $length
     * @param string $message
     */
    public function __construct($objectName, $length, $message = '')
    {
        $this->setLength($length);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" должно быть меньше {length}.';
    }
    
    protected function setLength($length)
    {
        
        TypeChecker::getInstance()
            ->isInt($length, 'length')
            ->throwTypeErrorIfNotValid();
        $this->length = $length;
    }
    
    public function length()
    {
        return (string)$this->length;
    }
}