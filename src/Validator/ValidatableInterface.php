<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:57
 */

namespace NewInventor\Form\Validator;

interface ValidatableInterface
{
    /**
     * @return boolean
     */
    public function isValid();

    /**
     * @param bool $revalidate
     * @return bool
     */
    public function validate($revalidate = false);

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