<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 23:35
 */

namespace NewInventor\Form\Handler;

use NewInventor\Form\FormObject;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Interfaces\HandlerInterface;
use NewInventor\Form\Renderer\HandlerRenderer;
use NewInventor\Form\Renderer\RendererInterface;

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
    public function getString()
    {
        $renderer = new HandlerRenderer();
        return $renderer->render($this);
    }
}