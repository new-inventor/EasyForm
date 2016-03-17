<?php

namespace NewInventor\EasyForm\Renderer\Renderers;

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

class PHPRenderer extends Object implements RendererInterface
{
    use SingletonTrait;

    public $reBlock = 'data-repeat-block';
    public $reContainer = 'data-repeat-container';
    public $reActionsBlock = 'data-repeat-actions';
    public $reDeleteAction = 'data-delete';
    public $reAddAction = 'data-add';

    public function __construct(array $options)
    {
        if(!ArrayHelper::isValidElementsTypes($options, [ObjectHelper::STRING])){
            throw new ArgumentException('', 'options');
        }
        foreach($options as $optionName => $option){
            $this->$optionName = $option;
        }
    }

    public static function getInstance(array $options = [])
    {
        if (null === self::$instance) {
            self::$instance = new static($options);
        }

        return self::$instance;
    }

    /**
     * @inheritdoc
     */
    public function form(FormInterface $form)
    {
        $formStr = '<form name="' . $form->getFullName() . '" ' . $form->attributes() . '>';
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
        $res = '';
        if($field->isRepeatable()){
            $res .= "<div {$this->reBlock}>";
        }else{
            $res .= "<span>{$field->getTitle()}</span>";
        }
        if ($field instanceof Field\CheckBox) {
            $res .= $this->checkBox($field);
        } elseif ($field instanceof Field\Select) {
            $res .= $this->select($field);
        } elseif ($field instanceof Field\CheckBoxSet) {
            $res .= $this->checkBoxSet($field);
        } elseif ($field instanceof Field\Input) {
            $res .= $this->input($field);
        } elseif ($field instanceof Field\RadioSet) {
            $res .= $this->radioSet($field);
        } elseif ($field instanceof Field\TextArea) {
            $res .= $this->textArea($field);
        }

        if($field->isRepeatable()){
            $res .= $this->getBlockRepeatActions($field) . '</div>';
        }
        $res .= implode('<br>', $field->getErrors());

        return $res;
    }

    protected function checkBox(Field\CheckBox $field)
    {
        $res = '<input name="' . $field->getFullName() . '" ' . $field->attributes();
        if ($field->getValue()) {
            $res .= ' checked';
        }
        $res .= '/>';

        return $res;
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
        $start = /** @lang text */
            "<input type=\"{$type}\" name=\"{$field->getFullName()}\"{$field->attributes()}";
        foreach ($field->options() as $option) {
            $res .= "{$start}value=\"{$option['value']}\"";
            if ($field->optionSelected($option['value'])) {
                $res .= ' checked';
            }
            $res .= '/>';
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
}