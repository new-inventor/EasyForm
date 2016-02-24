<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:32
 */

namespace NewInventor\EasyForm\Field;

use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class TextArea extends AbstractField implements FieldInterface
{
    /**
     * @return string
     */
    public function getString()
    {
        return '<textarea name="' . $this->getFullName() . '" ' . $this->attributes() . '>' . $this->getValue() . '</textarea>';
    }

    /**
     * @param int $count
     *
     * @return $this
     *
     * @throws ArgumentTypeException
     */
    public function cols($count)
    {
        if (!ObjectHelper::isValidType($count, [ObjectHelper::INT])) {
            throw new ArgumentTypeException('count', [ObjectHelper::INT], $count);
        }
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
        if (!ObjectHelper::isValidType($count, [ObjectHelper::INT])) {
            throw new ArgumentTypeException('count', [ObjectHelper::INT], $count);
        }
        $this->attribute('rows', $count);

        return $this;
    }
}