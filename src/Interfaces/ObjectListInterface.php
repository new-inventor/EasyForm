<?php
/**
 * User: Ionov George
 * Date: 15.02.2016
 * Time: 17:35
 */

namespace NewInventor\EasyForm\Interfaces;

interface ObjectListInterface extends ObjectInterface
{

    /**
     * @param string|int $index
     * @return ObjectInterface
     */
    public function get($index);

    /**
     * @param ObjectInterface $object
     * @throws \Exception
     * @return static
     */
    public function add($object);

    /**
     * @return ObjectInterface[]
     */
    public function getAll();

    /**
     * @param string|int $name
     * @return bool
     */
    public function delete($name);

    /**
     * @param ObjectInterface[] $pairs
     * @throws \Exception
     * @return static
     */
    public function addArray(array $pairs);

    /**
     * @param string[] $elementClasses
     * @return static
     */
    public function setElementClasses(array $elementClasses = []);

    /**
     * @return string[]
     */
    public function getElementClasses();

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count();

}