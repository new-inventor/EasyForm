<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 16:36
 */

namespace NewInventor\Form\Validator\Exceptions\Email;


use NewInventor\Form\Validator\Exceptions\Base;

class NotValid extends Base
{    
    protected function getDefaultMessage()
    {
        return 'Неверный формат электронной почты в поле "{n}".';
    }
}