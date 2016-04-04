<?php

namespace NewInventor\Form;

use NewInventor\Abstractions\Interfaces\ObjectListInterface;
use NewInventor\Abstractions\NamedObject;
use NewInventor\Abstractions\NamedObjectList;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Field\AbstractField;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Interfaces\FormObjectInterface;
use NewInventor\Form\Renderer\RenderableInterface;
use NewInventor\Form\Validator\ValidatableInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

abstract class FormObject extends NamedObject implements FormObjectInterface, ValidatableInterface, RenderableInterface
{
    /** @var ObjectListInterface|RenderableInterface */
    private $attrs;
    /** @var string */
    private $title;
    /** @var array */
    protected $errors = [];
    /** @var bool */
    protected $isValid;
    /** @var FormInterface|BlockInterface|null */
    private $parent = null;
    /** @var NamedObjectList */
    private $children = null;
    /** @var string */
    protected $templateName;

    const DEFAULT_TEMPLATE = 'default';

    /**
     * @param string $name
     * @param string $title
     *
     * @throws ArgumentTypeException
     */
    function __construct($name, $title = '')
    {
        $this->attrs = new NamedObjectList([KeyValuePair::getClass()]);
        $this->children = new NamedObjectList([Block::getClass(), AbstractField::getClass()]);
        parent::__construct($name);
        $this->title($title);
        $this->isValid = true;
        $this->templateName = self::DEFAULT_TEMPLATE;
    }

    /**
     * @inheritdoc
     */
    public function children()
    {
        return $this->children;
    }

    /**
     * @inheritdoc
     */
    public function child($name)
    {
        return $this->children()->get($name);
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return $this->attrs;
    }

    /**
     * @inheritdoc
     */
    public function getAttribute($name)
    {
        return $this->attrs->get($name);
    }

    /**
     * @inheritdoc
     */
    public function attribute($name, $value = '', $canBeShort = false)
    {
        if ($name != 'name') {
            $this->attributes()->add(new KeyValuePair($name, $value, $canBeShort));
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function title($title)
    {
        TypeChecker::getInstance()
            ->isString($title, 'title')
            ->throwTypeErrorIfNotValid();
        $this->title = $title;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFullName()
    {
        $objectName = $this->getName();
        /** @var FormObject|null $parent */
        $parent = $this->getParent();
        if (isset($parent)) {
            return $parent->getFullName() . '[' . $objectName . ']';
        }

        return $objectName;
    }

    public static function initFromArray(array $data)
    {
    }

    /**
     * @inheritdoc
     */
    public function end()
    {
        return $this->getParent();
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res = array_merge($res, [
            'title' => $this->getTitle(),
            'fullName' => $this->getFullName(),
            'attrs' => $this->attributes()->toArray()
        ]);

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        try {
            return $this->getString();
        }catch (\Exception $e){
            return "{$e->getMessage()}. File: {$e->getFile()}, Line: {$e->getLine()}, Stack trace: {$e->getTraceAsString()}";
        }
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        echo $this->getString();
    }

    /**
     * @inheritdoc
     */
    public function getString()
    {
        return '';
    }

    public function validate()
    {
        if ($this->children() !== null) {
            /** @var FieldInterface|BlockInterface $child */
            foreach ($this->children() as $child) {
                $child->validate();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function isValid()
    {
        if ($this->children() !== null) {
            /** @var FieldInterface|BlockInterface $child */
            foreach ($this->children() as $child) {
                $this->isValid = $this->isValid && $child->isValid();
            }
        }

        return $this->isValid;
    }

    /**
     * @inheritdoc
     */
    public function addError($error)
    {
        TypeChecker::getInstance()
            ->isString($error, 'error')
            ->throwTypeErrorIfNotValid();
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        $errors = $this->prepareErrors($this->errors);
        if ($this->children() !== null) {
            /** @var FieldInterface|BlockInterface $child */
            foreach ($this->children() as $child) {
                $errors = array_merge($errors, $child->getErrors());
            }
        }

        return $errors;
    }

    public function prepareErrors(array $errors = [])
    {
        return $errors;
    }

    /**
     * @inheritdoc
     */
    public function getDataArray()
    {
        if ($this instanceof FieldInterface) {
            return [$this->getName() => $this->getValue()];
        }

        $res = [];
        foreach ($this->children() as $child) {
            if ($child instanceof FieldInterface) {
                $res[$child->getName()] = $child->getValue();
            } elseif ($child instanceof BlockInterface) {
                $res[$child->getName()] = $child->getDataArray();
            }
        }

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function isRepeatable()
    {
        return $this->getParent() !== null && $this->getParent()->isRepeatableContainer();
    }

    /**
     * @inheritdoc
     */
    public function template($name)
    {
        TypeChecker::getInstance()->isString($name, 'name')->throwTypeErrorIfNotValid();
        $this->templateName = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTemplate()
    {
        return $this->templateName;
    }
}