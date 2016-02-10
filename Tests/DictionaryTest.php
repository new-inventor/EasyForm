<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 17:18
 */

namespace NewInventor\EasyForm\Tests;

use NewInventor\EasyForm\Abstraction\Dictionary;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $dict = new Dictionary([
            'text' => [
                'value' => 'qwe',
                'delimiter' => '=',
                'valueComas' => ['/', '/'],
                'nameComas' => ['{', '}']
            ]
        ]);
        $this->assertEquals('{text}=/qwe/', $dict->get('text')->getString());
    }
}
