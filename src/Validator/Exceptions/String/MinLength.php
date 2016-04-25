<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 17:00
 */

namespace NewInventor\Form\Validator\Exceptions\String;


use NewInventor\Form\Validator\Exceptions\String\Traits\MinLengthTrait;

class MinLength extends Base
{
    use MinLengthTrait;
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $minLength
     * @param string $message
     */
    public function __construct($objectName, $minLength, $message = '')
    {
        $this->setMinLength($minLength);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Длина значения поля "{n}" должна быть больше {minLength} символов.';
    }
}