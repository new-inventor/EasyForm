<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:00
 */

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Abstraction\NamedObjectList;
use NewInventor\EasyForm\Field\AbstractField;
use NewInventor\EasyForm\Field\Text;
use NewInventor\EasyForm\Interfaces\BlockInterface;

/**
 * Class AbstractBlock
 * @package NewInventor\EasyForm
 */
class AbstractBlock extends FormObject implements BlockInterface
{
    /**
     * AbstractBlock constructor.
     */
    public function __construct($name, $title = '', $repeatable = false)
    {
        parent::__construct($name, $title, $repeatable);
        $this->initChildren(new NamedObjectList([AbstractBlock::getClass(), AbstractField::getClass()]));

    }

    public function validate()
    {

    }

    public function field($type, $name, $value = '')
    {

    }

    public function block()
    {
        // TODO: Implement block() method.
    }

    public function repeatableBlock()
    {
        // TODO: Implement repeatedBlock() method.
    }

    public function repeatableField()
    {
        // TODO: Implement repeatedField() method.
    }

    public function button($name, $value = '')
    {
        // TODO: Implement button() method.
    }

    public function checkbox($name, $value = '')
    {
        // TODO: Implement checkbox() method.
    }

    public function file($name, $value = '')
    {
        // TODO: Implement file() method.
    }

    public function hidden($name, $value = '')
    {
        // TODO: Implement hidden() method.
    }

    public function image($name, $value = '')
    {
        // TODO: Implement image() method.
    }

    public function password($name, $value = '')
    {
        // TODO: Implement password() method.
    }

    public function radio($name, $value = '')
    {
        // TODO: Implement radio() method.
    }

    public function reset($name, $value = '')
    {
        // TODO: Implement reset() method.
    }

    public function submit($name, $value = '')
    {
        // TODO: Implement submit() method.
    }

    /**
     * @param string $name
     * @param string $value
     * @return Text
     */
    public function text($name, $value = '')
    {
        $field = new Text($name, $value);
        $field->setParent($this);
        $this->children()->add($field);

        return $field;
    }

    public function color($name, $value = '')
    {
        // TODO: Implement color() method.
    }

    public function date($name, $value = '')
    {
        // TODO: Implement date() method.
    }

    public function datetime($name, $value = '')
    {
        // TODO: Implement datetime() method.
    }

    public function datetimeLocal($name, $value = '')
    {
        // TODO: Implement datetimeLocal() method.
    }

    public function email($name, $value = '')
    {
        // TODO: Implement email() method.
    }

    public function number($name, $value = '')
    {
        // TODO: Implement number() method.
    }

    public function range($name, $value = '')
    {
        // TODO: Implement range() method.
    }

    public function search($name, $value = '')
    {
        // TODO: Implement search() method.
    }

    public function tel($name, $value = '')
    {
        // TODO: Implement tel() method.
    }

    public function time($name, $value = '')
    {
        // TODO: Implement time() method.
    }

    public function url($name, $value = '')
    {
        // TODO: Implement url() method.
    }

    public function month($name, $value = '')
    {
        // TODO: Implement month() method.
    }

    public function week($name, $value = '')
    {
        // TODO: Implement week() method.
    }

    public function getString()
    {
        $res = '';
        foreach($this->children() as $child){
            $res .= $child;
        }

        return $res;
    }
}