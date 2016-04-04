<?php
/**
 * User: Ionov George
 * Date: 23.03.2016
 * Time: 14:47
 */

namespace NewInventor\Form\Renderer;

use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\Abstractions\Object;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Abstraction\KeyValuePair;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Patterns\SingletonTrait;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\SimpleTypes;
use NewInventor\TypeChecker\TypeChecker;

class BaseRenderer extends Object implements RendererInterface
{
    use SingletonTrait;
    const FIELD = 'field';
    const BLOCK = 'block';
    const FORM = 'form';

    protected static $borders;

    public function __construct()
    {
        $default = include __DIR__ . '/defaultSettings.php';
        Config::merge(['renderer'], $default);
    }

    /** @inheritdoc */
    public function render(ObjectInterface $object)
    {
        return '';
    }

    /**
     * @param array           $placeholders
     * @param ObjectInterface $object
     *
     * @return array
     */
    protected function getReplacements(array $placeholders, ObjectInterface $object)
    {
        $replacements = [];
        foreach ($placeholders as $placeholder) {
            $replacements[] = $this->$placeholder($object);
        }

        return $replacements;
    }
}