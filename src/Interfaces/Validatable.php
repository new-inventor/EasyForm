<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:57
 */

namespace Interfaces;

use NewInventor\EasyForm\Abstraction\ObjectList;

interface Validatable
{
    /**
     * @return boolean
     */
    public function isValid();

    /**
     * @return ObjectList
     */
    public function validators();


    /**
     * @param $name
     * @return mixed
     */
    public function validator($name);

    public function validate();
}