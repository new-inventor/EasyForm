<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:32
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Template\Template;

/**
 * Class ErrorRendererTrait
 * @package NewInventor\Form\Renderer\Traits
 *
 * @method getReplacements(array $placeholders, $object)
 */
trait Errors
{
    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     *
     * @return string
     */
    protected function errors($object)
    {
        $errors = $object->getErrors();
        if (empty($errors)) {
            return '';
        }
        
        $templateStr = Config::find(
            ['renderer'],
            ['templates', $object->getTemplate(), 'errors'],
            $object->getClass(),
            ''
        );
        $template = new Template($templateStr);
        $replacements = $this->getReplacements($template->getPlaceholders(), $object);
        $template->setReplacements($replacements);
        
        return $template->getReplaced();
    }
    
    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     *
     * @return string
     */
    protected function errorsStr($object)
    {
        $errorDelimiter = Config::get(['renderer', 'errors', 'delimiter']);
        $errorsStr = implode($errorDelimiter, $object->getErrors());
        
        return $errorsStr;
    }
}