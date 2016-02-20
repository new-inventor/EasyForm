<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Abstraction\KeyValuePair;
use NewInventor\EasyForm\Abstraction\NamedObject;
use NewInventor\EasyForm\Abstraction\NamedObjectList;
use NewInventor\EasyForm\Abstraction\TreeNode;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FormObjectInterface;
use NewInventor\EasyForm\Interfaces\NamedObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;
use NewInventor\EasyForm\Validator\ValidatableInterface;
use NewInventor\EasyForm\Validator\ValidatorInterface;

abstract class FormObject extends NamedObject implements FormObjectInterface, ValidatableInterface, RenderableInterface
{
    use TreeNode;
    /** @var ObjectListInterface|RenderableInterface */
    private $attrs;
    /** @var string */
    private $title;
    /** @var bool */
    private $repeatable;
    /** @var NamedObjectList */
    protected $validators;
    /** @var array */
    protected $errors;
    /** @var bool */
    protected $isValid;

    function __construct($name, $title = '', $repeatable = false)
    {
        $this->attrs = new NamedObjectList([KeyValuePair::getClass()]);
        $this->attrs->setObjectsDelimiter(' ');
        parent::__construct($name);
        $this->setTitle($title);
        if (!ObjectHelper::isValidType($repeatable, [ObjectHelper::BOOL])) {
            throw new ArgumentTypeException('repeatable', [ObjectHelper::BOOL], $repeatable);
        }
        $this->repeatable = $repeatable;
        $this->validators = new NamedObjectList(['NewInventor\EasyForm\Interfaces\ValidatorInterface']);
        $this->isValid = true;
    }

    /**
     * @return ObjectListInterface|RenderableInterface
     */
    public function attributes()
    {
        return $this->attrs;
    }

    /**
     * @param $name
     * @return NamedObjectInterface
     * @throws ArgumentTypeException
     */
    public function attribute($name)
    {
        return $this->attrs->get($name);
    }

    /**
     * @return bool
     */
    public function isRepeatable()
    {
        return $this->repeatable;
    }

    /**
     * @return static
     */
    public function repeatable()
    {
        $this->repeatable = true;

        return $this;
    }

    /**
     * @return static
     */
    public function single()
    {
        $this->repeatable = false;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return static
     * @throws ArgumentTypeException
     */
    public function setTitle($title)
    {
        if (ObjectHelper::isValidType($title, [ObjectHelper::STRING])) {
            $this->title = $title;

            return $this;
        }
        throw new ArgumentTypeException('title', [ObjectHelper::STRING], $title);
    }

    /**
     * @return string
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

    public static function initFromArray(array $data){}

    public function end()
    {
        return $this->getParent();
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res = array_merge($res, [
            'title' => $this->getTitle(),
            'repeatable' => $this->isRepeatable(),
            'fullName' => $this->getFullName(),
            'attrs' => $this->attributes()->toArray()
        ]);

        return $res;
    }

    public function __toString()
    {
        return $this->getString();
    }

    public function render()
    {
        echo $this->getString();
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @return NamedObjectList
     */
    public function validators()
    {
        return $this->validators;
    }

    /**
     * @param $name
     * @return ValidatorInterface
     * @throws ArgumentTypeException
     */
    public function validator($name)
    {
        return $this->validators->get($name);
    }

    public function addError($error){
        if (ObjectHelper::isValidType($error, [ObjectHelper::STRING])) {
            $this->errors[] = $error;

            return $this;
        }
        throw new ArgumentTypeException('error', [ObjectHelper::STRING], $error);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}