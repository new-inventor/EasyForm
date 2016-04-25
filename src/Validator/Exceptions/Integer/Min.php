<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 13:56
 */

namespace Validator\Exceptions\Integer;


use Validator\Exceptions\Base;

class Min extends Base
{
    protected function getMessageString($message)
    {
        return $message ?: "Значение не верно.";
    }
}