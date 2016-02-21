<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 22:40
 */

namespace NewInventor\EasyForm\Exception;


class RestrictMethodException extends \Exception {

    public function __construct($code = 0, \Exception $previous = null)
    {
        parent::__construct('Нельзя вызывать этот метод.', $code, $previous);
    }
}