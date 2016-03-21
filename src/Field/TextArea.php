<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:32
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class TextArea extends AbstractField implements FieldInterface
{
    /**
     * @param int $count
     *
     * @return $this
     *
     * @throws ArgumentTypeException
     */
    public function cols($count)
    {
        TypeChecker::getInstance()->isInt($count, 'count')->throwTypeErrorIfNotValid();
        $this->attribute('cols', $count);

        return $this;
    }

    /**
     * @param int $count
     *
     * @return $this
     *
     * @throws ArgumentTypeException
     */
    public function rows($count)
    {
        TypeChecker::getInstance()->isInt($count, 'count')->throwTypeErrorIfNotValid();
        $this->attribute('rows', $count);

        return $this;
    }
}