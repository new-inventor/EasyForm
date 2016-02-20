<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 21:39
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\HtmlAttr;

class Password extends Input
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

        $this->attributes()->add(HtmlAttr::build('type', 'password'));
    }
}