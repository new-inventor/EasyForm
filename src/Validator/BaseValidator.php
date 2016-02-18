<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 17:00
 */

namespace Validator;

use Interfaces\ValidatorInterface;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ArrayHelper;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\FieldInterface;

class BaseValidator implements ValidatorInterface
{
    /** @var string */
    private $errorTemplate;
    /** @var FieldInterface */
    private $field;
    private $defaultErrorTemplateParameters = [
        'name',
        'value'
    ];
    private $errorTemplateParameters = [];

    /**
     * BaseValidator constructor.
     * @param string $errorTemplate
     * @param array $errorTemplateParameters
     * @param FieldInterface $field
     * @throws ArgumentTypeException
     */
    public function __construct(FieldInterface $field, $errorTemplate = 'Не правильно заполнено поле "#NAME#"', array $errorTemplateParameters = [])
    {
        $this->setErrorTemplate($errorTemplate);
        if(!ArrayHelper::isValidElementsTypes($errorTemplateParameters, [ObjectHelper::STRING])){
            throw new ArgumentTypeException('errorTemplateParameters', [ObjectHelper::STRING], $errorTemplateParameters);
        }
        $this->errorTemplateParameters = array_merge($this->defaultErrorTemplateParameters , $errorTemplateParameters);
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getErrorTemplate()
    {
        return $this->errorTemplate;
    }

    /**
     * @param string $errorTemplate
     * @throws ArgumentTypeException
     */
    public function setErrorTemplate($errorTemplate)
    {
        if (ObjectHelper::isValidArgumentType($errorTemplate, [ObjectHelper::STRING])) {
            $this->errorTemplate = $errorTemplate;
        }
        throw new ArgumentTypeException('errorTemplate', [ObjectHelper::STRING], $errorTemplate);
    }

    public function isValid()
    {
        return true;
    }

    public function getError()
    {
        return [];
    }
}