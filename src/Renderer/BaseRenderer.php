<?php
/**
 * User: Ionov George
 * Date: 23.03.2016
 * Time: 14:47
 */

namespace NewInventor\EasyForm\Renderer;

use NewInventor\EasyForm\Abstraction\Object;
use NewInventor\EasyForm\Abstraction\SimpleTypes;
use NewInventor\EasyForm\Abstraction\SingletonTrait;
use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Interfaces\FormObjectInterface;
use NewInventor\EasyForm\Interfaces\HandlerInterface;
use NewInventor\EasyForm\Settings;
use NewInventor\EasyForm\Interfaces\FormInterface;

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
        Settings::getInstance()->merge(['renderer'], $default);
        $borders = Settings::getInstance()->get(['renderer', 'placeholders', 'borders']);
        if($this->isValidBorders($borders)) {
            self::$borders = $borders;
        }
    }

    /**
     * @param array $borders
     * @return bool
     * @throws ArgumentException
     */
    protected static function isValidBorders(array $borders)
    {
        TypeChecker::getInstance()
            ->checkArray($borders, [SimpleTypes::STRING], 'borders')
            ->throwCustomErrorIfNotValid('Границы должны быть строкой.');
        if (!isset($borders[0]) || !isset($borders[1])) {
            throw new ArgumentException('Границы должны быть массивом из 2-х элементов - левой и правой границей заполнителя.', 'borders');
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function form(FormInterface $form)
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function block(BlockInterface $block)
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function field(FieldInterface $field)
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function handler(HandlerInterface $handler)
    {
        return '';
    }

    /**
     * @param string $template
     * @param FormObjectInterface $object
     * @return mixed
     */
    protected function replacePlaceholders($template = '', FormObjectInterface $object = null, array $options = []){
        $placeholders = $this->getTemplatePlaceholders($template);
        $res = $template;
        foreach ($placeholders as $placeholder) {
            $method = $this->getMethodName($placeholder);
            $placeholderContent = $this->$method($object, $options);
            $res = preg_replace('/\{' . $placeholder . '\}/u', $placeholderContent, $res);
        }

        return $res;
    }

    protected function getMethodName($str)
    {
        return $str;
    }

    /**
     * @param string $template
     * @param bool $withBorders
     *
     * @return array
     */
    protected function getTemplatePlaceholders($template, $withBorders = false)
    {
        $regexp = self::getPlaceholderSearchRegexp();
        $searchRes = preg_match_all($regexp, $template, $foundPlaceholders);
        if ($searchRes === 0 || $searchRes === false) {
            return [];
        }

        return $withBorders ? $foundPlaceholders[0] : $foundPlaceholders[1];
    }



    /**
     * @return string
     * @throws ArgumentException
     */
    public function getPlaceholderSearchRegexp()
    {
        $leftBorder = preg_quote(self::$borders[0]);
        $rightBorder = preg_quote(self::$borders[1]);
        $regexp = "{$leftBorder}([^{$rightBorder}]*){$rightBorder}";
        $regexp = "/{$regexp}/u";

        return $regexp;
    }
}