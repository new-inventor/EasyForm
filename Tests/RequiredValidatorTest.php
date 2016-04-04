<?php
/**
 * User: Ionov George
 * Date: 16.03.2016
 * Time: 15:59
 */

use \NewInventor\Form\Validator\Validators\RequiredValidator;

class RequiredValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testRequired()
    {
        $validator = new RequiredValidator();

        $this->assertFalse($validator->isValid(''));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid([]));

        $this->assertTrue($validator->isValid('email'));
        $this->assertTrue($validator->isValid(['dfdf', 'dfsdf']));
        $this->assertTrue($validator->isValid(1));
        $this->assertTrue($validator->isValid(0));
    }
}
