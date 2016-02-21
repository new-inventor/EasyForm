<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:00
 */

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Field\Input;
use NewInventor\EasyForm\Field\Select;
use NewInventor\EasyForm\Field\TextArea;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;

/**
 * Class AbstractBlock
 * @package NewInventor\EasyForm
 */
class AbstractBlock extends FormObject implements BlockInterface
{
    /**
     * AbstractBlock constructor.
     *
     * @param string $name
     * @param string $title
     * @param bool   $repeatable
     */
    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function block($name, $title = '')
    {
        $block = new AbstractBlock($name, $title);
        $block->setParent($this);
        $this->children()->add($block);

        return $block;
    }

    /**
     * @inheritdoc
     */
    public function button($name, $value = '')
    {
        return $this->addInputField('button', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function checkbox($name, $value = '')
    {
        return $this->addInputField('checkbox', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function file($name, $value = '')
    {
        return $this->addInputField('file', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function hidden($name, $value = '')
    {
        return $this->addInputField('hidden', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function image($name, $value = '')
    {
        return $this->addInputField('image', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function password($name, $value = '')
    {
        return $this->addInputField('password', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function radio($name, $value = '')
    {
        return $this->addInputField('radio', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function reset($name, $value = '')
    {
        return $this->addInputField('reset', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function submit($name, $value = '')
    {
        return $this->addInputField('submit', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function text($name, $value = '')
    {
        return $this->addInputField('text', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function color($name, $value = '')
    {
        return $this->addInputField('color', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function date($name, $value = '')
    {
        return $this->addInputField('date', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function datetime($name, $value = '')
    {
        return $this->addInputField('datetime', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function datetimeLocal($name, $value = '')
    {
        return $this->addInputField('datetimeLocal', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function email($name, $value = '')
    {
        return $this->addInputField('email', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function number($name, $value = '')
    {
        return $this->addInputField('number', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function range($name, $value = '')
    {
        return $this->addInputField('range', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function search($name, $value = '')
    {
        return $this->addInputField('search', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function tel($name, $value = '')
    {
        return $this->addInputField('tel', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function time($name, $value = '')
    {
        return $this->addInputField('time', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function url($name, $value = '')
    {
        return $this->addInputField('url', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function month($name, $value = '')
    {
        return $this->addInputField('month', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function week($name, $value = '')
    {
        return $this->addInputField('week', $name, $value);
    }

    protected function addInputField($type, $name, $value)
    {
        $field = new Input($name, $value);
        $field->attribute('type', $type);

        return $this->field($field);
    }

    /**
     * @inheritdoc
     */
    public function select($name, $value = null)
    {
        $select = new Select($name, $value, '');

        return $this->field($select);
    }

    /**
     * @inheritdoc
     */
    public function textArea($name, $value = '')
    {
        $textArea = new TextArea($name, $value);

        return $this->field($textArea);
    }

    /**
     * @inheritdoc
     */
    public function field($field)
    {
        $field->setParent($this);
        $this->children()->add($field);

        return $field;
    }

    /**
     * @inheritdoc
     */
    public function getString()
    {
        $res = $this->children()->getString();

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function load($data = null)
    {
        if (!ObjectHelper::isValidType($data, [ObjectHelper::ARR, ObjectHelper::NULL])) {
            throw new ArgumentTypeException('data', [ObjectHelper::ARR, ObjectHelper::NULL], $data);
        }
        if ($data === null && isset($_REQUEST[$this->getName()])) {
            $data = $_REQUEST[$this->getName()];
        }elseif($data === null){
            return false;
        }

        foreach ($data as $name => $value) {
            $child = $this->child($name);
            if ($child instanceof FieldInterface) {
                $child->setValue($value);
            } elseif ($child instanceof BlockInterface) {
                $child->load($value);
            }
        }

        return true;
    }
}