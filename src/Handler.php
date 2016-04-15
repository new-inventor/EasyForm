<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 23:35
 */

namespace NewInventor\Form;

use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Interfaces\HandlerInterface;
use NewInventor\Form\Renderer\HandlerRenderer;
use NewInventor\TypeChecker\Exception\ArgumentException;

class Handler extends FormObject implements HandlerInterface
{
    const PROCESS_TYPE_CLOSURE = 0;
    const PROCESS_TYPE_CALLABLE = 1;
    
    /** @var \Closure|callable */
    protected $process;
    /** @var int */
    protected $processType;
    
    /**
     * Handler constructor.
     * @param FormInterface $form
     * @param callable|\Closure $process
     * @param string $name
     * @param string $value
     */
    function __construct(FormInterface $form, $process, $name = 'abstractHandler', $value = 'Абстрактное действие')
    {
        parent::__construct($name, $value);
        $this->setParent($form);
        $this->attribute('type', 'submit');
        $this->attribute('value', $value);
        $this->attribute('id', $name);
        $this->setProcess($process);
    }
    
    /**
     * @inheritdoc
     */
    public function setProcess($process)
    {
        if (!isset($process)) {
            throw new ArgumentException('Функция обработчика не передана.', 'process');
        }
        if ($process instanceof \Closure) {
            $this->processType = self::PROCESS_TYPE_CLOSURE;
        } elseif (is_string($process) && function_exists($process)) {
            $this->processType = self::PROCESS_TYPE_CALLABLE;
        } elseif (is_array($process) && call_user_func_array('method_exists', $process)) {
            $this->processType = self::PROCESS_TYPE_CALLABLE;
        } else {
            throw new ArgumentException('Функция обработчика не существует.', 'process');
        }
        $this->process = $process;
    }
    
    /**
     * @inheritdoc
     */
    public function process()
    {
        if ($this->processType == self::PROCESS_TYPE_CLOSURE) {
            return $this->process->__invoke($this->getParent());
        } elseif ($this->processType == self::PROCESS_TYPE_CALLABLE) {
            return call_user_func($this->process, $this->getParent());
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function getString()
    {
        $renderer = new HandlerRenderer();
        return $renderer->render($this);
    }
}