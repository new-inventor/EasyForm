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

    public function testConstructShort()
    {
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
        try{
            $pair = new KeyValuePair('');
            $this->assertTrue(false);
        }catch(\Exception $e){
            $this->assertTrue(true);
        }
        try{
            $pair = new KeyValuePair([]);
            $this->assertTrue(false);
        }catch(\Exception $e){
            $this->assertTrue(true);
        }
        try{
            $pair = new KeyValuePair(new KeyValuePair('name'));
            $this->assertTrue(false);
        }catch(\Exception $e){
            $this->assertTrue(true);
        }
    }

    public function testConstructFromArray()
    {
        try{
            $pair = KeyValuePair::initFromArray([]);
            $this->assertTrue(false);
        }catch(\Exception $e){
            $this->assertTrue(true);
        }

        $pair = KeyValuePair::initFromArray(['name' => 'tag']);
        $this->assertEquals('tag', '' . $pair);

        $pair = KeyValuePair::initFromArray([
            'name' => 'tag',
            'value' => 'qwe',
            'delimiter' => '=',
            'canBeShort' => false,
            'nameComas' => '-',
            'valueComas' => '"'
        ]);
        $this->assertEquals('-tag-="qwe"', '' . $pair);

        $pair = KeyValuePair::initFromArray([
            'name' => 'tag',
            'value' => '',
            'delimiter' => '=',
            'canBeShort' => true,
            'nameComas' => '-',
            'valueComas' => '"'
        ]);
        $this->assertEquals('-tag-', '' . $pair);

        $pair = KeyValuePair::initFromArray([
            'name' => 'tag',
            'value' => '123',
            'delimiter' => '=',
            'canBeShort' => true,
            'nameComas' => ['-'],
            'valueComas' => ['*', '^']
        ]);
        $this->assertEquals('-tag-=*123^', '' . $pair);

        try{
            $pair = KeyValuePair::initFromArray([
                'name' => 'tag',
                'value' => '123',
                'delimiter' => '=',
                'canBeShort' => true,
                'nameComas' => [['1']],
                'valueComas' => ['*', 1]
            ]);
            $this->assertTrue(false);
        }catch(\Exception $e){
            $this->assertTrue(true);
        }
    }

    public function testValidComas()
    {
        $this->assertTrue(KeyValuePair::validComasArray(''));
        $this->assertTrue(KeyValuePair::validComasArray('\''));
        $this->assertTrue(KeyValuePair::validComasArray(['-']));
        $this->assertTrue(KeyValuePair::validComasArray(['-', '*']));
        $this->assertTrue(KeyValuePair::validComasArray(['-', '']));
        $this->assertTrue(KeyValuePair::validComasArray(['', '']));

        $this->assertFalse(KeyValuePair::validComasArray(1));
        $this->assertFalse(KeyValuePair::validComasArray(true));
        $this->assertFalse(KeyValuePair::validComasArray([]));
        $this->assertFalse(KeyValuePair::validComasArray(['-', '*', 2]));
        $this->assertFalse(KeyValuePair::validComasArray(new KeyValuePair('name')));
        $this->assertFalse(KeyValuePair::validComasArray(null));
        $this->assertFalse(KeyValuePair::validComasArray([[], '']));
        $this->assertFalse(KeyValuePair::validComasArray(['', []]));
    }

    public function testIsArrayParamsValid()
    {
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => '123',
                'delimiter' => '=',
                'canBeShort' => true,
                'nameComas' => ['1'],
                'valueComas' => ['*', '']
            ]
        ));
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => '123',
                'delimiter' => '=',
                'canBeShort' => false,
                'nameComas' => ['1'],
            ]
        ));
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => '123',
                'delimiter' => '=',
                'canBeShort' => true,
            ]
        ));
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => '123',
                'delimiter' => '=',
            ]
        ));
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => '123',
            ]
        ));
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
            ]
        ));
        $this->assertTrue(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => null,
                'delimiter' => null,
                'canBeShort' => null,
                'nameComas' => null,
                'valueComas' => null
            ]
        ));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid([]));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid(null));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid('dfsdf'));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'value' => [],
            ]
        ));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'delimiter' => [],
            ]
        ));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'canBeShort' => [],
            ]
        ));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'nameComas' => [],
            ]
        ));
        $this->assertFalse(KeyValuePair::IsArrayParamsValid(
            [
                'name' => 'tag',
                'valueComas' => [],
            ]
        ));
    }
}
