<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 13:56
 */

namespace NewInventor\Form\Validator\Exceptions\Integer;


use NewInventor\Form\Validator\Exceptions\Base;
use NewInventor\Form\Validator\Exceptions\Integer\Traits;

class Range extends Base
{
    use Traits\MinTrait;
    use Traits\MaxTrait;
    
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $minValue
     * @param int $maxValue
     * @param string $message
     */
    public function __construct($objectName, $minValue, $maxValue, $message = '')
    {
        $this->setMin($minValue);
        $this->setMax($maxValue);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" должно быть между {min} и {max}.';
    }
}