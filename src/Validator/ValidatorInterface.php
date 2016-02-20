<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:48
 */

namespace NewInventor\EasyForm\Validator;

interface ValidatorInterface
{
    /**
     * @param string|array|null $value
     * @return mixed
     */
    public function isValid($value);

    /**
     * @return string|null
     */
    public function getError();
}