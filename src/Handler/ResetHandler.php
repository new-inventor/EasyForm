<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 0:47
 */

namespace NewInventor\EasyForm\Handler;

use NewInventor\EasyForm\Field\Input;

class ResetHandler extends AbstractHandler
{
    private $oldValues;

    function __construct($parent)
    {
        parent::__construct($parent, 'resetHandler', 'Сбросить');
        $this->oldValues = $this->getParent()->getDataArray();
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

    public function process()
    {
        $this->getParent()->load($this->oldValues);
        return true;
    }
} 