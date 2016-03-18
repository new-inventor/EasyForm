<?php

namespace NewInventor\EasyForm\Renderer;

use DeepCopy\DeepCopy;
use NewInventor\EasyForm\Abstraction\Object;
use NewInventor\EasyForm\Abstraction\SingletonTrait;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Field;
use NewInventor\EasyForm\Helper\ArrayHelper;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\FormInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;
use NewInventor\EasyForm\Renderer\RendererInterface;
use NewInventor\EasyForm\Settings;

class Renderer extends Object implements RendererInterface
{
    use SingletonTrait;
    const FIELD = 'field';
    const BLOCK = 'block';
    const FORM = 'form';

    public function __construct()
    {
        $default = include __DIR__ . '/defaultSettings.php';
        Settings::getInstance()->merge(['renderer'], $default);
    }

    /**
     * @inheritdoc
     */
    public function form(FormInterface $form)
    {
        $formStr = '';
        $formStr .= '<form name="' . $form->getFullName() . '" ' . $form->attributes() . '>';
        $formStr .= $form->children();
        $formStr .= $form->handlers();
        $formStr .= '</form>';

        return $formStr;
    }

    /**
     * @inheritdoc
     */
    public function block(BlockInterface $block)
    {
        $res = "<div";
        if ($block->isRepeatable()) {
            $res .= ' ' . $this->reBlock;
        } elseif ($block->isRepeatableContainer()) {
            $res = "<span>{$block->getTitle()}</span><div " . $this->reContainer;
        }else{
            $res = "<span>{$block->getTitle()}</span><div";
        }
        $res .= '>';
        $res .= $block->children();
        if ($block->isRepeatable()) {
            $res .= $this->getBlockRepeatActions($block);
        }
        $res .= '</div>';
        if ($block->isRepeatableContainer()) {
            $res .= $this->repeatableBlockScript($block);
        }

        return $res;
    }

    /**
     * @param BlockInterface|FieldInterface $block
     * @return string
     */
    protected function getBlockRepeatActions($block)
    {
        $add = false;
        $delete = false;
        if ((int)$block->getName() != 0 || count($block->getParent()->children()) > 1) {
            $delete = true;
        }
        if ((int)$block->getName() == count($block->getParent()->children()) - 1) {
            $add = true;
        }

        return $this->getRepeatActions($block->getParent()->getName(), $add, $delete);
    }

    protected function getRepeatActions($name = '', $addButton = true, $deleteButton = false)
    {
        $res = "<div {$this->reActionsBlock}=\"{$name}\">";
        if ($deleteButton) {
            $res .= $this->getDeleteButton();
        }
        if ($addButton) {
            $res .= $this->getAddButton();
        }
        $res .= '</div>';

        return $res;
    }

    protected function getAddButton()
    {
        return "<span {$this->reAddAction}>+</span>";
    }

    protected function getDeleteButton()
    {
        return "<span {$this->reDeleteAction}>-</span>";
    }

    protected function repeatableBlockScript(BlockInterface $block)
    {
        $deepCopy = new DeepCopy();
        /** @var BlockInterface|FieldInterface|RenderableInterface $childCopy */
        $childCopy = $deepCopy->copy($block->getRepeatObject());
        $childCopy->clear();
        $childCopy->setParent($block);
        $res = '<script>
$(document).on("click", "[' . $this->reActionsBlock . '=\'' . $block->getName() . '\'] [' . $this->reDeleteAction . ']", function(e){
    e.preventDefault();
    var $this = $(this);
    var $container = $this.closest("[' . $this->reContainer . ']");
    if($container.find("[' . $this->reBlock . ']").length < 1){
        return;
    }
    var $block = $this.closest("[' . $this->reBlock . ']");
    if($block.find("[' . $this->reAddAction . ']").length > 0){
        $block.prev().find("[' . $this->reActionsBlock . ']").append(\'' . $this->getAddButton() . '\');
    }
    $block.remove();
    if($container.find("[' . $this->reBlock . ']").length == 1){
        $container.find("[' . $this->reBlock . ']:first [' . $this->reDeleteAction . ']").remove();
    }
});
$(document).on("click", "[' . $this->reActionsBlock . '=\'' . $block->getName() . '\'] [' . $this->reAddAction . ']", function(e){
    e.preventDefault();
    var $this = $(this);
    var $container = $this.closest("[' . $this->reContainer . ']");
    var dummy = \'' . $childCopy . '\';
    var $block = $this.closest("[' . $this->reBlock . ']");
    var index = $container.find("[' . $this->reBlock . ']").length;
    var $dummy = $(dummy.replace(/#IND#/g, index));
    if($block.find("[' . $this->reDeleteAction . ']").length == 0){
        $block.find("[' . $this->reActionsBlock . ']").append(\'' . $this->getDeleteButton() . '\');
    }
    $dummy.find("[' . $this->reActionsBlock . ']").remove();
    $dummy.append(\'' . $this->getRepeatActions($block->getName(), true, true) . '\');
    $container.append($dummy);
    $this.remove();
});
</script>';

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function field(FieldInterface $field)
    {
        $template = Settings::getInstance()->get(['renderer', 'templates', 'field'], self::DEFAULT_FIELD_TEMPLATE);
        $label = $this->getFieldLabel($field);
        $fieldStr = $this->getFieldStr($field);
        if($field->isRepeatable()){
            $fieldStr = "<div {$this->reBlock}>{$fieldStr}{$this->getBlockRepeatActions($field)}</div>";
        }
        $errors = $this->getErrorsStr($field, $template, self::FIELD);


        $template = preg_replace('/\{' . self::PLACEHOLDER_FIELD . '\}/u', $fieldStr, $template);
        $template = preg_replace('/\{' . self::PLACEHOLDER_LABEL . '\}/u', $label, $template);
        $template = preg_replace('/\{' . self::PLACEHOLDER_ERRORS . '\}/u', $errors, $template);

        return $template;
    }

    /**
     * @param FieldInterface $field
     * @return string
     */
    protected function getFieldLabel(FieldInterface $field)
    {
        $template = Settings::getInstance()->get(['renderer', 'label', 'template', 'field']);
        if($field->isRepeatable()&& strpos($template, $this->getPlaceholder('title')) === false){
            return '';
        }
        if($field->getTitle() == ''){
            return '';
        }
        $forField = '';
        if(strpos($template, $this->getPlaceholder('forField')) !== false){
            $forField = 'for="' . ($field->attributes()->get('id') != null ?: $field->getName()) . '"';
        }
        $template = preg_replace('/' . $this->getPlaceholderRegexp('title') . '/u', $field->getTitle(), $template);
        $template = preg_replace('/' . $this->getPlaceholderRegexp('forField') . '/u', (string)$forField, $template);

        return $template;
    }

    /**
     * @param FieldInterface|BlockInterface|FormInterface $formObject
     * @param string $template
     * @param string $type
     * @return string
     */
    protected function getErrorsStr(FieldInterface $formObject, $template, $type = self::FIELD)
    {
        $errors = '';
        if(strpos($template, $this->getPlaceholder('errors')) !== false && !empty($formObject->getErrors())) {
            $errorDelimiter = Settings::getInstance()->get(['renderer', 'error', 'template', 'delimiter']);
            $errors = implode($errorDelimiter, $formObject->getErrors());
        }
        Settings::getInstance()->get(['renderer', 'error', 'template', $type]);
        return $errors;
    }

    /**
     * @param FieldInterface $field
     * @return string
     */
    protected function getFieldStr(FieldInterface $field)
    {
        $fieldStr = '';
        if ($field instanceof Field\CheckBox) {
            $fieldStr = $this->checkBox($field);
        } elseif ($field instanceof Field\Select) {
            $fieldStr = $this->select($field);
        } elseif ($field instanceof Field\CheckBoxSet) {
            $fieldStr = $this->checkBoxSet($field);
        } elseif ($field instanceof Field\Input) {
            $fieldStr = $this->input($field);
        } elseif ($field instanceof Field\RadioSet) {
            $fieldStr = $this->radioSet($field);
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

    protected function checkBoxSet(Field\CheckBoxSet $field)
    {
        return $this->checkSet($field, 'checkbox');
    }

    protected function radioSet(Field\RadioSet $field)
    {
        return $this->checkSet($field, 'radio');
    }

    /**
     * @param Field\ListField $field
     * @param string $type
     * @return string
     */
    protected function checkSet(Field\ListField $field, $type)
    {
        $res = '';
        $asArray = ($type == 'checkbox') ? '[]' : '';
        $start = /** @lang text */
            "<input type=\"{$type}\" name=\"{$field->getFullName()}{$asArray}\"{$field->attributes()}";
        foreach ($field->options() as $option) {
            $checked = $field->optionSelected($option['value']) ? ' checked' : '';
            $res .= "{$option['title']}{$start} value=\"{$option['value']}\"{$checked} />";
        }

        return $res;
    }

    protected function input(Field\Input $field)
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

    /**
     * @param string $name
     * @return string
     */
    protected function getPlaceholder($name)
    {
        return '{' . Settings::getInstance()->get(['renderer', 'placeholder', $name]) . '}';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getPlaceholderRegexp($name)
    {
        return '\{' . Settings::getInstance()->get(['renderer', 'placeholder', $name]) . '\}';
    }
}