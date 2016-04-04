<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 0:47
 */

namespace NewInventor\Form\Handler;

class ResetHandler extends AbstractHandler
{
    private $oldValues;

    function __construct($parent)
    {
        parent::__construct($parent, 'resetHandler', 'Сбросить');
        $this->oldValues = $this->getParent()->getDataArray();
    }

    public function process()
    {
        $this->getParent()->load($this->oldValues);
        return true;
    }
} 