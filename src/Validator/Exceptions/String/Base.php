<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 16:48
 */

namespace NewInventor\Form\Validator\Exceptions\String;


class Base extends \NewInventor\Form\Validator\Exceptions\Base
{
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" не является строкой, удовлетворяющей условиям.';
    }
}