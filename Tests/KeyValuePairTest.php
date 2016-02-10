<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:55
 */

namespace NewInventor\EasyForm\Tests;

use NewInventor\EasyForm\Abstraction\KeyValuePair;

class KeyValuePairTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $pair = new KeyValuePair('pair', '', false);
        $this->assertEquals('pair', $pair->getString());
        $pair->setDelimiter('=');
        $this->assertEquals('pair=', $pair->getString());
        $pair->setNameComas('{');
        $this->assertEquals('{pair{=', $pair->getString());
        $pair->setNameComas('{', '}');
        $this->assertEquals('{pair}=', $pair->getString());
        $pair->setValueComas('/');
        $this->assertEquals('{pair}=//', $pair->getString());
        $pair->setValueComas('/', '}');
        $this->assertEquals('{pair}=/}', $pair->getString());
        $pair->setValue('123');
        $this->assertEquals('{pair}=/123}', $pair->getString());
    }
    public function testConstructShort(){
        $pair = new KeyValuePair('pair', '', true);
        $this->assertEquals('pair', $pair->getString());
        $pair->setDelimiter('=');
        $this->assertEquals('pair', $pair->getString());
        $pair->setNameComas('=');
        $this->assertEquals('=pair=', $pair->getString());
        $pair->setNameComas('=', '\'');
        $this->assertEquals('=pair\'', $pair->getString());
        $pair->setValueComas('"');
        $this->assertEquals('=pair\'', $pair->getString());
        $pair->setValue('123');
        $this->assertEquals('=pair\'="123"', $pair->getString());
    }
}
