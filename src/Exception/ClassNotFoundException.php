<?php

namespace NewInventor\EasyForm\Exception;

use Throwable;

class ClassNotFoundException implements \Throwable
{
    private $className;
    private $message;
    private $code;
    private $file;
    private $line;
    private $pre;

    /**
     * ClassNotFoundException constructor.
     * @param string $message
     * @param string $className
     */
    public function __construct($message = '', $className = '')
    {
        parent::__construct($message);
        $this->className = $className;
    }

    public function getMessage()
    {
        $parentMessage = parent::getMessage();
        if($parentMessage == ''){
            return 'Class' . $this->className . 'not found.';
        }else{
            return $parentMessage;
        }
    }

    public function getCode()
    {
        // TODO: Implement getCode() method.
    }

    public function getFile()
    {
        // TODO: Implement getFile() method.
    }

    public function getLine()
    {
        // TODO: Implement getLine() method.
    }

    public function getTrace()
    {
        // TODO: Implement getTrace() method.
    }

    public function getTraceAsString()
    {
        // TODO: Implement getTraceAsString() method.
    }

    public function getPrevious()
    {
        // TODO: Implement getPrevious() method.
    }

    public function __toString() {
        return $this->getMessage();
    }
}