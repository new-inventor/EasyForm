<?php

namespace NewInventor\EasyForm\Renderer;

use DeepCopy\DeepCopy;
use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Field;
use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\FormInterface;
use NewInventor\EasyForm\Interfaces\FormObjectInterface;
use NewInventor\EasyForm\Interfaces\HandlerInterface;
use NewInventor\EasyForm\Settings;

class Renderer extends BaseRenderer implements RendererInterface
{
    /**
     * @inheritdoc
     */
    public function form(FormInterface $form)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $form->getTemplate(), 'form']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $form);

        return $res;
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    public function formStart(FormInterface $form)
    {
        return '<form name="' . $form->getFullName() . '" ' . $form->attributes() . '>';
    }

    /**
     * @return string
     * @internal param FormInterface $form
     */
    public function formEnd()
    {
        return '</form>';
    }

    /**
     * @param FormInterface|BlockInterface $object
     * @return string
     */
    public function children($object)
    {
        return '' . $object->children();
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    public function handlers(FormInterface $form)
    {
        return '' . $form->handlers();
    }

    /**
     * @inheritdoc
     */
    public function handler(HandlerInterface $handler)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $handler->getTemplate(), 'handler']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $handler);

        return $res;
    }

    protected function handlerStr(HandlerInterface $handler)
    {
        return $this->input($handler->attribute('type', 'submit'));
    }

    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     * @return string
     */
    public function errors($object)
    {
        $errors = $object->getErrors();
        if (empty($errors)) {
            return '';
        }
        $template = Settings::getInstance()->find(['renderer'], ['templates', $object->getTemplate(), 'errors'], $object->getClass(), '');
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();

        $res = $this->replacePlaceholders($template, $object);

        return $res;
    }

    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     * @return string
     */
    public function errorsStr($object)
    {
        $errorDelimiter = Settings::getInstance()->get(['renderer', 'errors', 'delimiter']);
        $errorsStr = implode($errorDelimiter, $object->getErrors());

        return $errorsStr;
    }

    /**
     * @inheritdoc
     */
    public function block(BlockInterface $block)
    {
        if ($block->isRepeatable()) {
            return $this->repeatableBlock($block);
        } elseif ($block->isRepeatableContainer()) {
            return $this->repeatableContainer($block);
        } else {
            return $this->singleBlock($block);
        }
    }

    protected function singleBlock(BlockInterface $block)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'block']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block);

        return $res;
    }

    protected function repeatableBlock(BlockInterface $block)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'repeatBlock']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block);

        return $res;
    }

    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     * @return string
     */
    protected function label($object)
    {
        $template = Settings::getInstance()->find(['renderer'], ['templates', $object->getTemplate(), 'label'], $object->getClass(), '');
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $object);

        return $res;
    }

    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     * @return string
     */
    protected function title($object)
    {
        return $object->getTitle();
    }

    protected function repeatableContainer(BlockInterface $block)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'repeatContainer']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block);

        return $res;
    }

    protected function getRepeatableMark(BlockInterface $block)
    {
        return ' ' . Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'repeatBlock']);
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @return string
     */
    protected function actions($block)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'repeatActionsBlock']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block);

        return $res;
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     * @return string
     */
    protected function addButton($block, $check = true)
    {
        $res = '';
        if (((int)$block->getName() == count($block->getParent()->children()) - 1) && $check) {
            $template = Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'addButton']);
            TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
            $res = $this->replacePlaceholders($template, $block);
        }

        return $res;
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     * @return string
     */
    protected function deleteButton($block, $check = true)
    {
        $res = '';
        if (((int)$block->getName() != 0 || count($block->getParent()->children()) > 1) && $check) {
            $template = Settings::getInstance()->get(['renderer', 'templates', $block->getTemplate(), 'deleteButton']);
            TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
            $res = $this->replacePlaceholders($template, $block);
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

        $selector = Settings::getInstance()->get(['renderer', 'repeat', $type], '');
        TypeChecker::getInstance()->isString($selector, 'selector')->throwTypeErrorIfNotValid();

        return $selector;
    }

    protected function repeatScript(BlockInterface $block)
    {
        $deepCopy = new DeepCopy();
        /** @var BlockInterface|FieldInterface|RenderableInterface $childCopy */
        $childCopy = $deepCopy->copy($block->getRepeatObject());
        $childCopy->clear();
        $childCopy->setParent($block);
        $res = '<script>
$(document).on("click", "[' . $this->actionsBlockSelector() . '=\'' . $block->getName() . '\'] [' . $this->deleteActionSelector() . ']", function(e){
    e.preventDefault();
    var $this = $(this);
    var $container = $this.closest("[' . $this->containerSelector() . ']");
    if($container.find("[' . $this->blockSelector() . ']").length < 1){
        return;
    }
    var $block = $this.closest("[' . $this->blockSelector() . ']");
    if($block.find("[' . $this->addActionSelector() . ']").length > 0){
        $block.prev().find("[' . $this->actionsBlockSelector() . ']").append(\'' . $this->addButton($block) . '\');
    }
    $block.remove();
    if($container.find("[' . $this->blockSelector() . ']").length == 1){
        $container.find("[' . $this->blockSelector() . ']:first [' . $this->deleteActionSelector() . ']").remove();
    }
});
$(document).on("click", "[' . $this->actionsBlockSelector() . '=\'' . $block->getName() . '\'] [' . $this->addActionSelector() . ']", function(e){
    e.preventDefault();
    var $this = $(this);
    var $container = $this.closest("[' . $this->containerSelector() . ']");
    var dummy = \'' . $childCopy . '\';
    var $block = $this.closest("[' . $this->blockSelector() . ']");
    var index = $container.find("[' . $this->blockSelector() . ']").length;
    var $dummy = $(dummy.replace(/#IND#/g, index));
    if($block.find("[' . $this->deleteActionSelector() . ']").length == 0){
        $block.find("[' . $this->actionsBlockSelector() . ']").append(\'' . $this->deleteButton($block) . '\');
    }
    $dummy.find("[' . $this->actionsBlockSelector() . ']").remove();
    $dummy.append(\'' . $this->deleteButton($block, false) . $this->addButton($block, false) . '\');
    $container.append($dummy);
    $this.remove();
});
</script>';

        return $res;
    }

    /**
     * @param FieldInterface|FormInterface|BlockInterface $object
     * @return string
     */
    protected function name($object)
    {
        return $object->getParent()->getName();
    }

    /**
     * @inheritdoc
     */
    public function field(FieldInterface $field)
    {
        if ($field->isRepeatable()) {
            $template = Settings::getInstance()->get(['renderer', 'templates', $field->getTemplate(), 'repeatFiled']);
        } else {
            $template = Settings::getInstance()->get(['renderer', 'templates', $field->getTemplate(), 'field']);
        }
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $field);

        return $res;
    }

    protected function forField(FieldInterface $field)
    {
        return 'for="' . $field->attributes()->get('id')->getValue() . '"';
    }

    /**
     * @param FieldInterface $field
     * @return string
     */
    protected function fieldStr(FieldInterface $field)
    {
        $fieldStr = '';
        if ($field instanceof Field\CheckBox) {
            $fieldStr = $this->checkBox($field);
        } elseif ($field instanceof Field\Select) {
            $fieldStr = $this->select($field);
        } elseif ($field instanceof Field\CheckBoxSet) {
            $fieldStr = $this->checkSet($field);
        } elseif ($field instanceof Field\Input) {
            $fieldStr = $this->input($field);
        } elseif ($field instanceof Field\RadioSet) {
            $fieldStr = $this->checkSet($field);
        } elseif ($field instanceof Field\TextArea) {
            $fieldStr = $this->textArea($field);
        }

        return $fieldStr;
    }

    protected function checkBox(Field\CheckBox $field)
    {
        $checked = $field->getValue() ? ' checked' : '';

        return "<input name=\"{$field->getFullName()}\" {$field->attributes()}{$checked} />";
    }

    /**
     * @param Field\ListField $field
     * @return string
     */
    protected function checkSet(Field\ListField $field)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $field->getTemplate(), 'checkSet']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $field);

        return $res;
    }

    protected function options(Field\ListField $field)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', $field->getTemplate(), 'checkSetOption']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $options = '';
        foreach ($field->options() as $option) {
            $options .= $this->replacePlaceholders($template, $field, $option);
        }

        return $options;
    }

    protected function option(Field\ListField $field, array $options = [])
    {
        $type = '';
        if ($field instanceof Field\CheckBoxSet) {
            $type = 'checkbox';
        } elseif ($field instanceof Field\RadioSet) {
            $type = 'radio';
        }
        $asArray = ($type == 'checkbox') ? '[]' : '';
        $checked = $field->optionSelected($options['value']) ? ' checked' : '';
        $res = /** @lang text */
            "<input type=\"{$type}\" name=\"{$field->getFullName()}{$asArray}\"{$field->attributes()} value=\"{$options['value']}\"{$checked} />";

        return $res;
    }

    protected function optionTitle(Field\ListField $field, array $options = [])
    {
        return $options['title'];
    }

    protected function input(FormObjectInterface $field)
    {
        return "<input name=\"{$field->getFullName()}\" {$field->attributes()}/>";
    }

    protected function select(Field\Select $field)
    {
        $res = '<select name="' . $field->getFullName() . '" ' . $field->attributes() . '>';
        foreach ($field->options() as $option) {
            $optionString = '<option value="' . $option['value'] . '"';
            if ($field->optionSelected($option['value'])) {
                $optionString .= ' selected="selected"';
            }
            $optionString .= '>' . $option['title'] . '</option>';
            $res .= $optionString;
        }
        $res .= '</select>';

        return $res;
    }

    protected function textArea(Field\TextArea $field)
    {
        return '<textarea name="' . $field->getFullName() . '" ' . $field->attributes() . '>' . $field->getValue() . '</textarea>';
    }
}