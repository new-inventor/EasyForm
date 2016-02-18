<?php
/**
 * User: Ionov George
 * Date: 11.02.2016
 * Time: 8:59
 */

namespace NewInventor\EasyForm\Interfaces;

interface NamedObjectInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param array $data
     * @return static
     */
    public static function initFromArray(array $data);

    /**
     * @return mixed[]
     */
    public function toArray();

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function render();

    /**
     * @return string
     */
    public static function getClass();
}