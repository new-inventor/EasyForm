<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 17:00
 */

namespace NewInventor\Form\Validator\Exceptions\String;


use NewInventor\Form\Validator\Exceptions\String\Traits\MaxLengthTrait;

class MaxLength extends Base
{
    use MaxLengthTrait;
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $maxLength
     * @param string $message
     */
    public function __construct($objectName, $maxLength, $message = '')
    {
        $this->setMaxLength($maxLength);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Длина значения поля "{f}" должна быть меньше {maxLength} символов.';
    }
}