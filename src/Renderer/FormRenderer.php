<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:09
 */

namespace NewInventor\Form\Renderer;


use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Renderer\Traits;
use NewInventor\Template\Template;
use NewInventor\TypeChecker\TypeChecker;

class FormRenderer extends BaseRenderer
{
    use Traits\Attributes;
    use Traits\Errors;
    use Traits\Label;
    use Traits\Children;

    /** @inheritdoc */
    public function render(ObjectInterface $handler)
    {
        /** @var FormInterface $handler */
        $templateStr = Config::get(['renderer', 'templates', $handler->getTemplate(), 'form']);
        $template = new Template($templateStr);
        $replacements = $this->getReplacements($template->getPlaceholders(), $handler);
        $template->setReplacements($replacements);

        return $template->getReplaced();
    }

    /**
     * @param FormInterface $form
     *
     * @return string
     */
    protected function start(FormInterface $form)
    {
        return '<form ' . $this->attributes($form) . '>';
    }

    /**
     * @return string
     * @internal param FormInterface $form
     */
    protected function end()
    {
        return '</form>';
    }

    /**
     * @param FormInterface $form
     *
     * @return string
     */
    public function handlers(FormInterface $form)
    {
        return implode('', $form->handlers()->getAll());
    }
}