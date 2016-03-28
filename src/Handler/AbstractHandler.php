<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 23:35
 */

namespace NewInventor\EasyForm\Handler;

use NewInventor\EasyForm\FormObject;
use NewInventor\EasyForm\Interfaces\FormInterface;
use NewInventor\EasyForm\Interfaces\HandlerInterface;
use NewInventor\EasyForm\Renderer\RendererInterface;

class AbstractHandler extends FormObject implements HandlerInterface
{
    /** @var \Closure */
    protected $customProcess;

    function __construct($parent, $name = 'abstractHandler', $value = 'Абстрактное действие', \Closure $customProcess = null)
    {
        parent::__construct($name, $value);
        $this->setParent($parent);
        $this->attribute('type', 'submit');
        $this->attribute('value', $value);
        $this->attribute('id', $name);

        $this->customProcess = $customProcess;
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        if (isset($this->customProcess)) {
            return $this->customProcess->__invoke($this->getParent());
        }

        return $this->defaultProcess($this->getParent());
    }

    protected function defaultProcess(FormInterface $form)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validate(){}

    /**
     * @inheritdoc
     */
    protected function renderObject(RendererInterface $renderer)
    {
        return $renderer->handler($this);
    }
}