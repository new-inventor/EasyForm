<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 13:56
 */

namespace NewInventor\Form\Validator\Exceptions\Integer;


use NewInventor\Form\Validator\Exceptions\Base;
use NewInventor\Form\Validator\Exceptions\Integer\Traits\MaxTrait;

class Max extends Base
{
    use MaxTrait;
    
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $maxValue
     * @param string $message
     */
    public function __construct($objectName, $maxValue, $message = '')
    {
        $this->setMax($maxValue);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" должно быть меньше {max}.';
    }
}