<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:24
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class Text extends Input implements FieldInterface
{
    /**
     * Text constructor.
     * @param string $name
     * @param string $value
     * @param string $title
     * @param bool $repeatable
     */
    public function __construct($name, $value = '', $title = '', $repeatable = false)
    {
        parent::__construct($name, $value, $title, $repeatable);

        $this->attributes()->add(HtmlAttr::build('type', 'text'));
    }
}