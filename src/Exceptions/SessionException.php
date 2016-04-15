<?php
/**
 * User: Ionov George
 * Date: 15.04.2016
 * Time: 8:23
 */

namespace NewInventor\Form\Exceptions;


class SessionException extends \Exception
{
    public function __construct($message = '', $code = 0, $previous = null)
    {
        parent::__construct($this->getMessageString($message), $code, $previous);
    }

    protected function getMessageString($message)
    {
        $str = "Ошибка сессии: {$message}";
        return $str;
    }
}