<?php
/**
 * User: Ionov George
 * Date: 16.03.2016
 * Time: 15:59
 */

use \NewInventor\EasyForm\Validator\Validators\EmailValidator;

class EmailValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testEmail()
    {
        $validator = new EmailValidator();

        $this->assertTrue($validator->isValid(''));
        $this->assertFalse($validator->isValid('email'));
        $this->assertFalse($validator->isValid('email@email'));
        $this->assertTrue($validator->isValid('emasdasdil@asdsfsdf.ru'));
        $this->assertFalse($validator->isValid('email@23123'));
    }
}
