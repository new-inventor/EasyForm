<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:57
 */

namespace NewInventor\EasyForm\Validator;

use NewInventor\EasyForm\Abstraction\NamedObjectList;

interface ValidatableInterface
{
    /**
     * @return boolean
     */
    public function isValid();

    /**
     * @return void
     */
    public function validate();

    /**
     * @param string $error
     * @return static
     */
    public function addError($error);

    /**
     * @return string[]
     */
    public function getErrors();
}