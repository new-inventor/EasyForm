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
use NewInventor\TypeChecker\TypeChecker;

trait Repeatable
{
    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool                          $check
     *
     * @return string
     */
    protected function actions($block, $check = true)
    {
        $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatActionsBlock']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        //$res = $this->replacePlaceholders($template, $block, $check);

        return '';//$res;
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool                          $check
     *
     * @return string
     */
    protected function addButton($block, $check = true)
    {
        $res = '';
        if (((int)$block->getName() == count($block->getParent()->children()) - 1) || !$check) {
            $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'addButton']);
            TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
            //$res = $this->replacePlaceholders($template, $block);
        }

        return $res;
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool                          $check
     *
     * @return string
     */
    protected function deleteButton($block, $check = true)
    {
        $res = '';
        if (((int)$block->getName() != 0 || count($block->getParent()->children()) > 1) || !$check) {
            $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'deleteButton']);
            TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
            //$res = $this->replacePlaceholders($template, $block);
        }

        return $res;
    }

    protected function blockSelector()
    {
        return $this->getSelectorFromSettings('block');
    }

    protected function containerSelector()
    {
        return $this->getSelectorFromSettings('container');
    }

    protected function actionsBlockSelector()
    {
        return $this->getSelectorFromSettings('actionsBlock');
    }

    protected function deleteActionSelector()
    {
        return $this->getSelectorFromSettings('deleteAction');
    }

    protected function addActionSelector()
    {
        return $this->getSelectorFromSettings('addAction');
    }

    protected function getSelectorFromSettings($type = '')
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
    protected function name($object)
    {
        return $object->getParent()->getName();
    }
}