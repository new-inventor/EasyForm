<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:00
 */

namespace NewInventor\EasyForm;

use NewInventor\EasyForm\Interfaces\BlockInterface;

class AbstractBlock extends FormObject implements BlockInterface
{
    /**
     * AbstractBlock constructor.
     */
    public function __construct($name, $title = '', $repeatable = false)
    {
        parent::__construct($name, $title, $repeatable);
        $this->children()->setElementClasses([AbstractBlock::getClass(), AbstractField::getClass()]);
    }
}