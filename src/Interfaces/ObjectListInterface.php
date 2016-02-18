<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 17:35
 */

namespace NewInventor\EasyForm\Interfaces;

interface ObjectListInterface
{
    /**
     * @return string
     */
    public function getObjectsDelimiter();

    /**
     * @param string $pairDelimiter
     * @return ObjectListInterface
     */
    public function setObjectsDelimiter($pairDelimiter);

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param mixed $pair
     * @throws \Exception
     * @return ObjectListInterface
     */
    public function add($pair);

    /**
     * @return mixed[]
     */
    public function getAll();

    /**
     * @param string $name
     * @return bool
     */
    public function delete($name);

    /**
     * @param mixed[] $pairs
     * @throws \Exception
     * @return ObjectListInterface
     */
    public function addArray(array $pairs);

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function render();

    /**
     * @return array
     */
    public function toArray();
}