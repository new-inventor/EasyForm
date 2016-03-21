<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Abstraction\KeyValuePair;
use NewInventor\EasyForm\Abstraction\NamedObject;
use NewInventor\EasyForm\Abstraction\NamedObjectList;
use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Field\AbstractField;
use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\FormInterface;
use NewInventor\EasyForm\Interfaces\FormObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;
use NewInventor\EasyForm\Renderer\Renderer;
use NewInventor\EasyForm\Renderer\RendererInterface;
use NewInventor\EasyForm\Validator\ValidatableInterface;

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

    /**
     * @param string $name
     * @param string $title
     *
     * @throws ArgumentTypeException
     */
    function __construct($name, $title = '')
    {
        $this->attrs = new NamedObjectList([KeyValuePair::getClass()]);
        $this->attrs->setObjectsDelimiter(' ');
        $this->children = new NamedObjectList([Block::getClass(), AbstractField::getClass()]);
        parent::__construct($name);
        $this->title($title);
        $this->isValid = true;
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
    public function attribute($name, $value = '')
    {
        $this->attributes()->add(HtmlAttr::build($name, $value));

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
        return $this->getString();
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
        $rendererClass = Settings::getInstance()->get(['renderer', 'class'], Renderer::getClass());
        if (isset($rendererClass)) {
            /** @var RendererInterface $renderer */
            $renderer = call_user_func([$rendererClass, 'getInstance']);

            if (in_array('NewInventor\EasyForm\Interfaces\FormInterface', class_implements($this))) {
                /** @var FormInterface $this */
                return $renderer->form($this);
            } elseif (in_array('NewInventor\EasyForm\Interfaces\BlockInterface', class_implements($this))) {
                /** @var BlockInterface $this */
                return $renderer->block($this);
            } elseif (in_array('NewInventor\EasyForm\Interfaces\FieldInterface', class_implements($this))) {
                /** @var FieldInterface $this */
                return $renderer->field($this);
            }
        }

        return '';
    }

    public function validate()
    {
        if ($this->children() !== null) {
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
}