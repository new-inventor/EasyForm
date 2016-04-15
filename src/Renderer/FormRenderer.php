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
use NewInventor\Form\Form;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Renderer\Traits;
use NewInventor\Template\Template;

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
    
    /**
     * @param FormInterface $form
     *
     * @return string
     */
    public function result(FormInterface $form)
    {
        if ($form->getStatus() == Form::STATUS_SHOW_RESULT) {
            $templateStr = Config::get(['renderer', 'templates', $form->getTemplate(), 'result']);
            $template = new Template($templateStr);
            $replacements = $this->getReplacements($template->getPlaceholders(), $form);
            $template->setReplacements($replacements);
            return $template->getReplaced();
        }
        return '';
    }
    
    public function className(FormInterface $form)
    {
        if (isset($form->getResult()['success'])) {
            return $form->getResult()['success'] ? 'success' : 'danger';
        }
        return '';
    }
    
    public function message(FormInterface $form)
    {
        if (isset($form->getResult()['message'])) {
            return $form->getResult()['message'];
        }
        return '';
    }
    
    /**
     * @param FormInterface $form
     *
     * @return string
     */
    public function scripts(FormInterface $form)
    {
        $composerPath = $_SERVER['DOCUMENT_ROOT'] . '/composer.json';
        $composerConfig = json_decode(file_get_contents($composerPath), true);
        $vendorFolder = $composerConfig['config']['vendor-dir'];
        
        $res = '';
        if ($form->showJQuery()) {
            if ($this->pingJquery()) {
                $res .= '<script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>';
            } else {
                $res .= "<script src='{$vendorFolder}/jquery/jquery/jquery-1.12.1.min.js'></script>";
            }
        }
        $res .= "<script src='{$vendorFolder}/new-inventor/form/src/assets/default.js'></script>";
        return $res;
    }
    
    protected function pingJquery()
    {
        $ch = curl_init('https://code.jquery.com/jquery-1.12.1.min.js');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode >= 200 && $httpcode < 300) {
            return true;
        } else {
            return false;
        }
    }
}