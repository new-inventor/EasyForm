<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 17:00
 */

namespace NewInventor\Form\Validator\Exceptions\String;


class Regexp extends Base
{
    
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $minLength
     * @param int $maxLength
     * @param string $message
     */
    public function __construct($objectName, $message = '')
    {
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" не удовлетворяет правилам.';
    }
}