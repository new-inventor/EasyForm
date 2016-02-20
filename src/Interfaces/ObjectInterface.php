<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 18:00
 */

namespace NewInventor\EasyForm\Interfaces;

interface ObjectInterface
{
    /**
     * @return mixed[]
     */
    public function toArray();

    /**
     * @param array $data
     * @return static
     */
    public static function initFromArray(array $data);

    /**
     * @return string
     */
    public static function getClass();
}