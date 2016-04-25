<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:44
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Template\Template;
use NewInventor\TypeChecker\TypeChecker;

/**
 * Class Repeatable
 * @package NewInventor\Form\Renderer\Traits
 *
 * @method getReplacements(array $placeholders, $object)
 */
trait Repeatable
{
    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     *
     * @return string
     */
    public function actions($block, $check = true)
    {
        $templateStr = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatActionsBlock']);
        $template = new Template($templateStr);
        
        return $template->getString($this, $block, $check);
    }
    
    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     *
     * @return string
     */
    public function addButton($block, $check = true)
    {
        $res = '';
        if (((int)$block->getName() == count($block->getParent()->children()) - 1) || !$check) {
            $templateStr = Config::get(['renderer', 'templates', $block->getTemplate(), 'addButton']);
            $template = new Template($templateStr);
            $res = $template->getString($this, $block);
        }
        
        return $res;
    }
    
    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     *
     * @return string
     */
    public function deleteButton($block, $check = true)
    {
        $res = '';
        if (((int)$block->getName() != 0 || count($block->getParent()->children()) > 1) || !$check) {
            $templateStr = Config::get(['renderer', 'templates', $block->getTemplate(), 'deleteButton']);
            $template = new Template($templateStr);
            $res = $template->getString($this, $block);
        }
        
        return $res;
    }
    
    public function blockSelector()
    {
        return $this->getSelectorFromSettings('block');
    }
    
    public function containerSelector()
    {
        return $this->getSelectorFromSettings('container');
    }
    
    public function actionsBlockSelector()
    {
        return $this->getSelectorFromSettings('actionsBlock');
    }
    
    public function deleteActionSelector()
    {
        return $this->getSelectorFromSettings('deleteAction');
    }
    
    public function addActionSelector()
    {
        return $this->getSelectorFromSettings('addAction');
    }
    
    public function getSelectorFromSettings($type = '')
    {
        if (empty($type)) {
            return '';
        }
        
        $selector = Config::get(['renderer', 'repeat', $type], '');
        TypeChecker::getInstance()->isString($selector, 'selector')->throwTypeErrorIfNotValid();
        
        return $selector;
    }
    
    /**
     * @param FieldInterface|BlockInterface $object
     *
     * @return string
     */
    public function name($object)
    {
        return $object->getParent()->getName();
    }
}