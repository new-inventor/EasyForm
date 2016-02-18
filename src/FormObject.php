<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\KeyValuePair;
use NewInventor\EasyForm\Abstraction\NamedObject;
use NewInventor\EasyForm\Abstraction\ObjectList;
use NewInventor\EasyForm\Abstraction\TreeNode;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FormObjectInterface;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;

abstract class FormObject extends NamedObject implements FormObjectInterface
{
    use TreeNode;
    /** @var ObjectListInterface */
    private $attrs;
    /** @var string */
    private $title;
    /** @var bool */
    private $repeatable;

    function __construct($name, $title = '', $repeatable = false)
    {
        parent::__construct($name);
        $this->attrs = new ObjectList([KeyValuePair::getClass()]);
        $this->setTitle($title);
        if (!ObjectHelper::isValidArgumentType($repeatable, [ObjectHelper::BOOL])) {
            throw new ArgumentTypeException('repeatable', [ObjectHelper::BOOL], $repeatable);
        }
        $this->repeatable = $repeatable;
    }

    /**
     * @return ObjectListInterface
     */
    public function attributes()
    {
        return $this->attrs;
    }

    /**
     * @param $name
     * @return ObjectListInterface
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
        if (ObjectHelper::isValidArgumentType($title, [ObjectHelper::STRING])) {
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

    public function __toString(){}

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

    public function render()
    {
        return '';
    }

    public function show()
    {
        echo $this->render();
    }
}