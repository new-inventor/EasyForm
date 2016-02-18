<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace Validator;

use Interfaces\ValidatorInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class StringValidator extends BaseValidator implements ValidatorInterface
{

    /**
     * StringValidator constructor.
     * @param FieldInterface $field
     * @param int $minLen
     * @param int $maxLen
     */
    public function __construct(FieldInterface $field, $minLen = null, $maxLen = null)
    {
        parent::__construct($field, '', ['MIN_LEN', 'MAX_LEN']);
    }

    public function isValid()
    {
        // TODO: Implement isValid() method.
    }

    public function getError()
    {
        // TODO: Implement getError() method.
    }
}