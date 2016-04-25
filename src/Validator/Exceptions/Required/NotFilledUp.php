<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 16:44
 */

namespace NewInventor\Form\Validator\Exceptions\Required;


use NewInventor\Form\Validator\Exceptions\Base;

class NotFilledUp extends Base
{
    protected function getDefaultMessage()
    {
        return 'Поле "{n}" обязательно для заполнения.';
    }
}