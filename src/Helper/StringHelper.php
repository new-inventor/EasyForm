<?php
/**
 * User: Ionov George
 * Date: 21.03.2016
 * Time: 10:25
 */

namespace Helper;

use NewInventor\EasyForm\Abstraction\SimpleTypes;
use NewInventor\EasyForm\Abstraction\TypeChecker;
use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Helper\ArrayHelper;

class StringHelper
{

    /**
     * @param string $template
     * @param array $borders
     * @param bool $withBorders
     * @return array
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public static function getTemplatePlaceholders($template, array $borders = ['{', '}'], $withBorders = true)
    {
        TypeChecker::getInstance()
            ->check($template, [SimpleTypes::STRING, SimpleTypes::ARR, SimpleTypes::INT], 'template')
            ->throwTypeErrorIfNotValid();
        TypeChecker::getInstance()
            ->isBool($withBorders, 'withBorders')
            ->throwTypeErrorIfNotValid();

        $regexp = self::getPlaceholderSearchRegexp($borders);
        $searchRes = preg_match_all($regexp, $template, $foundPlaceholders);

        if ($searchRes === 0 || $searchRes === false) {
            return [];
        }

        return $withBorders ? $foundPlaceholders[0] : $foundPlaceholders[1];
    }

    /**
     * @param array $borders
     * @return string
     * @throws ArgumentException
     */
    public static function getPlaceholderSearchRegexp(array $borders = ['{', '}'])
    {
        self::isValidBorders($borders);
        $regexp = preg_quote($borders[0] . '([^' . $borders[1] . ']*)' . $borders[1]);
        $regexp = "/{$regexp}/u";

        return $regexp;
    }

    /**
     * @param string $placeholder
     * @param array $borders
     * @return string
     * @throws ArgumentException
     */
    public static function getPlaceholderRegexp($placeholder, array $borders = ['{', '}'])
    {
        self::isValidBorders($borders);
        $regexp = preg_quote($borders[0] . $placeholder . $borders[1]);
        $regexp = "/{$regexp}/u";

        return $regexp;
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
     * @param string $template
     * @param string[] $pairs array of key => value pairs where key is a placeholder and value is replacement text
     * @return string
     * @throws ArgumentTypeException
     */
    public static function replacePlaceholders($template, array $pairs = [])
    {
        TypeChecker::getInstance()
            ->isString($template, 'template')
            ->throwTypeErrorIfNotValid();
        $placeholders = array_keys($pairs);
        foreach ($placeholders as $key => $placeholder) {
            $placeholders[] = '/' . $placeholder . '/u';
        }

        $template = preg_replace($placeholders, array_values($pairs), $template);

        return $template;
    }
}