<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:42
 */

namespace NewInventor\Form\Renderer;


use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Field;
use NewInventor\Form\Interfaces\FormObjectInterface;
use NewInventor\Form\Renderer\Traits;
use NewInventor\Template\Template;

class FieldRenderer extends BaseRenderer
{
    use Traits\Attributes;
    use Traits\Label;
    use Traits\Errors;
    use Traits\Repeatable;
    
    /** @inheritdoc */
    public function render(ObjectInterface $field)
    {
        /** @var FieldInterface $field */
        if ($field->isRepeatable()) {
            $templateStr = Config::get(['renderer', 'templates', $field->getTemplate(), 'repeatFiled']);
        } else {
            $templateStr = Config::get(['renderer', 'templates', $field->getTemplate(), 'field']);
        }
        $template = new Template($templateStr);
        
        return $template->getString($this, $field);
    }
    
    public function forField(FieldInterface $field)
    {
        return 'for="' . $field->attributes()->get('id')->getValue() . '"';
    }
    
    /**
     * @param FieldInterface $field
     *
     * @return string
     */
    public function field(FieldInterface $field)
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
    
    public function checkBox(Field\CheckBox $field)
    {
        $checked = $field->getValue() ? ' checked' : '';
        
        return "<input {$this->attributes($field)}{$checked} />";
    }
    
    /**
     * @param Field\ListField $field
     *
     * @return string
     */
    public function checkSet(Field\ListField $field)
    {
        $templateStr = Config::get(['renderer', 'templates', $field->getTemplate(), 'checkSet']);
        $template = new Template($templateStr);
        
        return $template->getString($this, $field);
    }
    
    public function options(Field\ListField $field)
    {
        $templateStr = Config::get(['renderer', 'templates', $field->getTemplate(), 'checkSetOption']);
        $template = new Template($templateStr);
        $options = '';
        foreach ($field->options() as $option) {
            $options .= $template->getString($this, $field, $option);
        }
        
        return $options;
    }
    
    /**
     * @param array $placeholders
     * @param FieldInterface $field
     * @param array $option
     *
     * @return array
     */
    public function getOptionReplacements(array $placeholders, FieldInterface $field, array $option)
    {
        $res = [];
        foreach ($placeholders as $placeholder) {
            $res[] = $this->$placeholder($field, $option);
        }
        
        return $res;
    }
    
    public function option(Field\ListField $field, array $option = [])
    {
        $checked = $field->optionSelected($option['value']) ? ' checked' : '';
        
        $res = /** @lang text */
            "<input {$this->renderOptionAttributes($field)} value=\"{$option['value']}\"{$checked} />";
        
        return $res;
    }
    
    public function renderOptionAttributes(Field\ListField $field)
    {
        $renderer = new AttributeRenderer();
        $asArray = '';
        $type = '';
        if ($field instanceof Field\CheckBoxSet) {
            $type = 'checkbox';
            $asArray = '[]';
        } elseif ($field instanceof Field\RadioSet) {
            $type = 'radio';
        }
        $type = new KeyValuePair('type', $type);
        $name = new KeyValuePair('name', $field->getFullName() . $asArray);
        $attrs = [$renderer->render($type), $renderer->render($name)];
        foreach ($field->attributes() as $attr) {
            $attrs[] = $renderer->render($attr);
        }
        
        return implode(' ', $attrs);
    }
    
    public function optionTitle(Field\ListField $field, array $option = [])
    {
        return $option['title'];
    }
    
    public function input(FormObjectInterface $field)
    {
        
        return "<input {$this->attributes($field)}/>";
    }
    
    public function select(Field\Select $field)
    {
        $res = '<select ' . $this->attributes($field) . '>';
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
    
    public function textArea(Field\TextArea $field)
    {
        return "<textarea {$this->attributes($field)}>{$field->getValue()}</textarea>";
    }
}