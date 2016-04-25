<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 14:02
 */

namespace NewInventor\Form\Validator\Exceptions\Integer;



class Base extends \NewInventor\Form\Validator\Exceptions\Base
{
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" не является целым числом.';
    }
}