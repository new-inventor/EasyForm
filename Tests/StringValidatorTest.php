<?php
/**
 * User: Ionov George
 * Date: 16.03.2016
 * Time: 15:23
 */

use \NewInventor\EasyForm\Validator\Validators\StringValidator;

class StringValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testLength()
    {
        $validator = new StringValidator();
        $validator->setLength(5);

        $this->assertFalse($validator->isValid('dasdas'));
        $this->assertFalse($validator->isValid('dasd'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(['dfsdf']));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid('asdfg'));
    }

    public function testMinLength()
    {
        $validator = new StringValidator();
        $validator->setMinLength(5);

        $this->assertFalse($validator->isValid('dasd'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(['dfsdf']));

        $this->assertTrue($validator->isValid('asdfg'));
        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid('dasdasdfsdfsdf'));
    }

    public function testMaxLength()
    {
        $validator = new StringValidator();
        $validator->setMaxLength(5);

        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(['dfsdf']));
        $this->assertFalse($validator->isValid('dasdasdfsdfsdf'));

        $this->assertTrue($validator->isValid('dasd'));
        $this->assertTrue($validator->isValid('asdfg'));
        $this->assertTrue($validator->isValid(''));
    }

    public function testMinMaxLength()
    {
        $validator = new StringValidator();
        $validator->setMinLength(5);
        $validator->setMaxLength(10);

        $this->assertFalse($validator->isValid('dasd'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(['dfsdf']));
        $this->assertFalse($validator->isValid('dasdasdfsdfsdf'));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid('dasds'));
        $this->assertTrue($validator->isValid('asdfgasdfg'));
    }

    public function testRegexp1()
    {
        $validator = new StringValidator();
        $validator->setRegexp('/^1{10}$/u');

        $this->assertFalse($validator->isValid('dasd'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(['dfsdf']));
        $this->assertFalse($validator->isValid('11111'));
        $this->assertFalse($validator->isValid('111111111111111111'));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid('1111111111'));
    }

    public function testRegexp2()
    {
        $validator = new StringValidator();
        $validator->setRegexp('/^1*$/u');

        $this->assertFalse($validator->isValid('dasd'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(['dfsdf']));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid('1111111111'));
        $this->assertTrue($validator->isValid('11111'));
        $this->assertTrue($validator->isValid('111111111111111111'));
    }
}
