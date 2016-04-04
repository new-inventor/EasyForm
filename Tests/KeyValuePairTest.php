<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:55
 */

namespace NewInventor\Form\Tests;

use NewInventor\Form\Abstraction\KeyValuePair;

class KeyValuePairTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $pair = new KeyValuePair('pair', '', false);
        $this->assertEquals('pair', $pair->render());
        $pair->setDelimiter('=');
        $this->assertEquals('pair=', $pair->render());
        $pair->setNameComas('{');
        $this->assertEquals('{pair{=', $pair->render());
        $pair->setNameComas('{', '}');
        $this->assertEquals('{pair}=', $pair->render());
        $pair->setValueComas('/');
        $this->assertEquals('{pair}=//', $pair->render());
        $pair->setValueComas('/', '}');
        $this->assertEquals('{pair}=/}', $pair->render());
        $pair->setValue('123');
        $this->assertEquals('{pair}=/123}', $pair->render());
    }

    public function testConstructShort()
    {
        $pair = new KeyValuePair('pair', '', true);
        $this->assertEquals('pair', $pair->render());
        $pair->setDelimiter('=');
        $this->assertEquals('pair', $pair->render());
        $pair->setNameComas('=');
        $this->assertEquals('=pair=', $pair->render());
        $pair->setNameComas('=', '\'');
        $this->assertEquals('=pair\'', $pair->render());
        $pair->setValueComas('"');
        $this->assertEquals('=pair\'', $pair->render());
        $pair->setValue('123');
        $this->assertEquals('=pair\'="123"', $pair->render());
        try {
            $pair = new KeyValuePair('');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
        try {
            $pair = new KeyValuePair([]);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
        try {
            $pair = new KeyValuePair(new KeyValuePair('name'));
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function testConstructFromArray()
    {
        try {
            $pair = KeyValuePair::initFromArray([]);
            $this->assertTrue(false);
        } catch (\Exception $e) {
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

        try {
            $pair = KeyValuePair::initFromArray([
                'name' => 'tag',
                'value' => '123',
                'delimiter' => '=',
                'canBeShort' => true,
                'nameComas' => [['1']],
                'valueComas' => ['*', 1]
            ]);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function testValidComasArray()
    {
        $this->assertTrue(KeyValuePair::isValidComasArray(''));
        $this->assertTrue(KeyValuePair::isValidComasArray('\''));
        $this->assertTrue(KeyValuePair::isValidComasArray(['-']));
        $this->assertTrue(KeyValuePair::isValidComasArray(['-', '*']));
        $this->assertTrue(KeyValuePair::isValidComasArray(['-', '']));
        $this->assertTrue(KeyValuePair::isValidComasArray(['', '']));

        $this->assertFalse(KeyValuePair::isValidComasArray(1));
        $this->assertFalse(KeyValuePair::isValidComasArray(true));
        $this->assertFalse(KeyValuePair::isValidComasArray([]));
        $this->assertFalse(KeyValuePair::isValidComasArray(['-', '*', 2]));
        $this->assertFalse(KeyValuePair::isValidComasArray(new KeyValuePair('name')));
        $this->assertFalse(KeyValuePair::isValidComasArray(null));
        $this->assertFalse(KeyValuePair::isValidComasArray([[], '']));
        $this->assertFalse(KeyValuePair::isValidComasArray(['', []]));
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

    public function testName()
    {
        $pair = new KeyValuePair('');
        $pair->setName('123');
        $name = $pair->getName();
        $this->assertEquals('123', $name);
    }

    public function testValue()
    {
        $pair = new KeyValuePair('');
        $pair->setValue('123');
        $value = $pair->getValue();
        $this->assertEquals('123', $value);
    }

    public function testDelimiter()
    {
        $pair = new KeyValuePair('');
        $pair->setDelimiter('123');
        $delimiter = $pair->getDelimiter();
        $this->assertEquals('123', $delimiter);
    }

    public function testValueComas()
    {
        $pair = new KeyValuePair('');
        $pair->setValueComas('123');
        $comas = $pair->getValueComas();
        $this->assertEquals(['123', '123'], $comas);
        $pair->setValueComas('123', '321');
        $comas = $pair->getValueComas();
        $this->assertEquals(['123', '321'], $comas);
    }

    public function testNameComas()
    {
        $pair = new KeyValuePair('');
        $pair->setNameComas('123');
        $comas = $pair->getNameComas();
        $this->assertEquals(['123', '123'], $comas);
        $pair->setNameComas('123', '321');
        $comas = $pair->getNameComas();
        $this->assertEquals(['123', '321'], $comas);
    }
}
