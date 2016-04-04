<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:32
 */

namespace NewInventor\Form\Field;

use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

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