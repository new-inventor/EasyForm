<?php
/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 14:07
 */

return [
    'email' => \NewInventor\EasyForm\Validator\Validators\EmailValidator::getClass(),
    'integer' => \NewInventor\EasyForm\Validator\Validators\IntegerValidator::getClass(),
    'string' => \NewInventor\EasyForm\Validator\Validators\StringValidator::getClass(),
    'required' => \NewInventor\EasyForm\Validator\Validators\RequiredValidator::getClass(),
];