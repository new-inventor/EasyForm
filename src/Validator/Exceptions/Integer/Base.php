<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 14:02
 */

namespace Validator\Exceptions\Integer;


use NewInventor\TypeChecker\TypeChecker;

class Base extends \Validator\Exceptions\Base
{
    protected $minValue;
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $minValue
     * @param string $message
     */
    public function __construct($objectName, $minValue, $message = '')
    {
        $this->setObjectName($objectName);
        
        parent::__construct($this->getMessageString($message));
    }
    
    protected function getDefaultMessage($message)
    {
        return 'Значение поля "{f}" не является целым числом.';
    }
    
    protected function setMinValue($minValue)
    {
        TypeChecker::getInstance()
            ->isInt($minValue, 'minValue')
            ->throwTypeErrorIfNotValid();
        $this->minValue = $minValue;
    }
}