<?php

/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 10:17
 */
class ArrayHelperTest extends PHPUnit_Framework_TestCase
{
    public function testIsValidElementsTypes()
    {
    }

    public function testGetByRoute()
    {
        $array = ['123', ['12321'], 'asd' => '12321', 'qwe' => ['qwe', 'asd', 'zxc']];

        $this->assertEquals('123', \NewInventor\EasyForm\Helper\ArrayHelper::getByRoute($array, [0]));
        $this->assertEquals('12321', \NewInventor\EasyForm\Helper\ArrayHelper::getByRoute($array, ['asd']));
        $this->assertEquals('zxc', \NewInventor\EasyForm\Helper\ArrayHelper::getByRoute($array, ['qwe', 2]));
        $this->assertEquals(1, \NewInventor\EasyForm\Helper\ArrayHelper::getByRoute($array, ['asdfg'], 1));
        $this->assertEquals(null, \NewInventor\EasyForm\Helper\ArrayHelper::getByRoute($array, ['asdfg']));
    }

    public function testGetByIndex()
    {
        $array = ['123', ['12321'], 'asd' => '12321', 'qwe' => ['qwe', 'asd', 'zxc']];

        $this->assertEquals('123', \NewInventor\EasyForm\Helper\ArrayHelper::getByIndex($array, 0));
        $this->assertEquals('12321', \NewInventor\EasyForm\Helper\ArrayHelper::getByIndex($array, 'asd'));
        $this->assertEquals(['qwe', 'asd', 'zxc'], \NewInventor\EasyForm\Helper\ArrayHelper::getByIndex($array, 'qwe'));
        $this->assertEquals(1, \NewInventor\EasyForm\Helper\ArrayHelper::getByIndex($array, 'asdfg', 1));
        $this->assertEquals(null, \NewInventor\EasyForm\Helper\ArrayHelper::getByIndex($array, 'asdfg'));
    }

    public function testGet()
    {
        $array = ['123', ['12321'], 'asd' => '12321', 'qwe' => ['qwe', 'asd', 'zxc' => '123']];

        $this->assertEquals('123', \NewInventor\EasyForm\Helper\ArrayHelper::get($array, 0));
        $this->assertEquals('12321', \NewInventor\EasyForm\Helper\ArrayHelper::get($array, 'asd'));
        $this->assertEquals(['qwe', 'asd', 'zxc' => '123'], \NewInventor\EasyForm\Helper\ArrayHelper::get($array, 'qwe'));
        $this->assertEquals(1, \NewInventor\EasyForm\Helper\ArrayHelper::get($array, ['asdfg'], 1));
        $this->assertEquals(null, \NewInventor\EasyForm\Helper\ArrayHelper::get($array, ['asdfg']));
        $this->assertEquals('123', \NewInventor\EasyForm\Helper\ArrayHelper::get($array, ['qwe', 'zxc']));
    }

    public function testSet()
    {
        $array = ['123', 'qwe' => ['12321']];

        $this->assertEquals(['123', 'qwe' => '11111'], \NewInventor\EasyForm\Helper\ArrayHelper::set($array, ['qwe'], '11111'));
        $this->assertEquals(['123', 'qwe' => ['12321'], 'asd' => '123'], \NewInventor\EasyForm\Helper\ArrayHelper::set($array, ['asd'], '123'));
        $this->assertEquals(['123', 'qwe' => ['111']], \NewInventor\EasyForm\Helper\ArrayHelper::set($array, ['qwe', 0], '111'));
        $this->assertEquals(['111', 'qwe' => ['12321']], \NewInventor\EasyForm\Helper\ArrayHelper::set($array, 0, '111'));
        $this->assertEquals(['123', 'qwe' => '111'], \NewInventor\EasyForm\Helper\ArrayHelper::set($array, 'qwe', '111'));
        $this->assertEquals(['123', 'qwe' => 11], \NewInventor\EasyForm\Helper\ArrayHelper::set($array, 'qwe', 11));
    }
}
