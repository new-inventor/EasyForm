<?php

namespace NewInventor\Form\Renderer;

use DeepCopy\DeepCopy;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Field;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Interfaces\FormObjectInterface;
use NewInventor\Form\Interfaces\HandlerInterface;
use NewInventor\TypeChecker\TypeChecker;

class Renderer extends BaseRenderer implements RendererInterface
{
    /**
     * @inheritdoc
     */
    public function form(FormInterface $form)
    {
        $templateStr = Config::get(['renderer', 'templates', $form->getTemplate(), 'form']);
        $template = new Template($templateStr);
        $replacements = $this->getReplacements($template->getPlaceholders(), $form);
        $template->setReplacements($replacements);

        return $template->getReplaced();
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    public function formStart(FormInterface $form)
    {
        return '<form ' . $this->attributes($form) . '>';
    }

    protected function attributes(FormObjectInterface $object)
    {
        $template = Config::get(['renderrer', 'templates', $object->getTemplate(), 'attribute']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $name = new KeyValuePair('name', $object->getFullName());
        $attrs = [$this->replacePlaceholders($template, $name)];
        foreach($object->attributes() as $attr){
            $res[] = $this->replacePlaceholders($template, $attr);
        }

        return implode(' ', $attrs);
    }

    protected function attrName(KeyValuePair $pair)
    {
        return $pair->getName();
    }

    protected function attrValue(KeyValuePair $pair)
    {
        return $pair->getValue();
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
        $template = Config::get(['renderer', 'templates', $handler->getTemplate(), 'handler']);
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
        $template = Config::find(['renderer'], ['templates', $object->getTemplate(), 'errors'], $object->getClass(), '');
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
        $errorDelimiter = Config::get(['renderer', 'errors', 'delimiter']);
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
        $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'block']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block);

        return $res;
    }

    protected function repeatableBlock(BlockInterface $block)
    {
        $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatBlock']);
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
        $template = Config::find(['renderer'], ['templates', $object->getTemplate(), 'label'], $object->getClass(), '');
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
        $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatContainer']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block);

        return $res;
    }

    protected function getRepeatableMark(BlockInterface $block)
    {
        return ' ' . Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatBlock']);
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     * @return string
     */
    protected function actions($block, $check = true)
    {
        $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatActionsBlock']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $block, $check);

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
        if (((int)$block->getName() == count($block->getParent()->children()) - 1) || !$check) {
            $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'addButton']);
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
        if (((int)$block->getName() != 0 || count($block->getParent()->children()) > 1) || !$check) {
            $template = Config::get(['renderer', 'templates', $block->getTemplate(), 'deleteButton']);
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

        $selector = Config::get(['renderer', 'repeat', $type], '');
        TypeChecker::getInstance()->isString($selector, 'selector')->throwTypeErrorIfNotValid();

        return $selector;
    }

    /**
     * @inheritdoc
     */
    public function field(FieldInterface $field)
    {
        if ($field->isRepeatable()) {
            $template = Config::get(['renderer', 'templates', $field->getTemplate(), 'repeatFiled']);
        } else {
            $template = Config::get(['renderer', 'templates', $field->getTemplate(), 'field']);
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
        $template = Config::get(['renderer', 'templates', $field->getTemplate(), 'checkSet']);
        TypeChecker::getInstance()->isString($template, 'template')->throwTypeErrorIfNotValid();
        $res = $this->replacePlaceholders($template, $field);

        return $res;
    }

    protected function options(Field\ListField $field)
    {
        $template = Config::get(['renderer', 'templates', $field->getTemplate(), 'checkSetOption']);
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