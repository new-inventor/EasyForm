<?php
/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 14:07
 */

return [
    'email' => \NewInventor\Form\Validator\Validators\EmailValidator::getClass(),
    'integer' => \NewInventor\Form\Validator\Validators\IntegerValidator::getClass(),
    'string' => \NewInventor\Form\Validator\Validators\StringValidator::getClass(),
    'required' => \NewInventor\Form\Validator\Validators\RequiredValidator::getClass(),
];