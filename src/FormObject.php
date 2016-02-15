<?php

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\ObjectList;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Abstraction\KeyValuePair;
use NewInventor\EasyForm\Abstraction\NamedObject;
use NewInventor\EasyForm\Abstraction\TreeNode;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Interfaces\ObjectListInterface;

class FormObject extends NamedObject
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
        $this->attrs = new ObjectList(KeyValuePair::getClass());
        $this->setTitle($title);
    }

    /**
     * @return ObjectListInterface
     */
    public function attributes()
    {
        return $this->attrs;
    }

    /**
     * @return bool
     */
    public function isRepeatable()
    {
        return $this->repeatable;
    }

    /**
     * @param bool $repeatable
     * @return static
     * @throws ArgumentTypeException
     */
    public function setRepeatable($repeatable)
    {
        return $this->setField('repeatable', $repeatable, [ObjectHelper::BOOL]);
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
        return $this->setField('title', $title, [ObjectHelper::STRING]);
    }

    /**
     * @param null|int $index
     * @return string
     */
    public function getFullName($index = null)
    {
        $name = $this->getName();
        /** @var FormObject|null $parent */
        $parent = $this->getParent();
        if(isset($parent)){
            $name = '[' . $name . ']';
        }
        if($this->isRepeatable()){
            $name .= '[';
            if(isset($index) && ObjectHelper::isValidArgumentType($index, [ObjectHelper::INT])){
                $name .= $index;
            }
            $name .= ']';
        }
        $name = $parent->getFullName() . $name;

        return $name;
    }

    public static function initFromArray(array $data)
    {
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}