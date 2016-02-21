<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 23:35
 */

namespace NewInventor\EasyForm\Handler;

use NewInventor\EasyForm\Field\Input;
use NewInventor\EasyForm\FormObject;
use NewInventor\EasyForm\Interfaces\HandlerInterface;

class AbstractHandler extends FormObject implements HandlerInterface
{
    function __construct($parent, $name = 'abstractHandler', $value = 'Абстрактное действие')
    {
        parent::__construct($name, $value);
        $this->setParent($parent);
    }

    /**
     * Преобразовать объект в строку
     * @return string
     */
    public function getString()
    {
        $button = new Input($this->getFullName(), $this->getTitle());
        return $button->type('submit')->getString();
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validate(){}
}