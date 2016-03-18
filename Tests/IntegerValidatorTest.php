<?php

/**
 * User: Ionov George
 * Date: 16.03.2016
 * Time: 16:27
 */

use \NewInventor\EasyForm\Validator\Validators\IntegerValidator;
class IntegerValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testMin(){
        $validator = new IntegerValidator();
        $validator->setMin(0);

        $this->assertFalse($validator->isValid('-1'));
        $this->assertFalse($validator->isValid('dfsdfsdf'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid([]));
        $this->assertFalse($validator->isValid('12312.231'));
        $this->assertFalse($validator->isValid(12312.231));
        $this->assertFalse($validator->isValid(12312.231));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid(1));
        $this->assertTrue($validator->isValid(1432));
    }

    public function testMax(){
        $validator = new IntegerValidator();
        $validator->setMax(100);

        $this->assertFalse($validator->isValid('dfsdfsdf'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid([]));
        $this->assertFalse($validator->isValid('12312.231'));
        $this->assertFalse($validator->isValid(12312.231));
        $this->assertFalse($validator->isValid(12312.231));
        $this->assertFalse($validator->isValid(1432));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid(1));
        $this->assertTrue($validator->isValid('-1'));
    }

    public function testMinMax(){
        $validator = new IntegerValidator();
        $validator->setMin(0);
        $validator->setMax(100);

        $this->assertFalse($validator->isValid('dfsdfsdf'));
        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid([]));
        $this->assertFalse($validator->isValid('12312.231'));
        $this->assertFalse($validator->isValid(12312.231));
        $this->assertFalse($validator->isValid(12312.231));
        $this->assertFalse($validator->isValid(1432));
        $this->assertFalse($validator->isValid('101'));
        $this->assertFalse($validator->isValid('-1'));

        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid(1));
        $this->assertTrue($validator->isValid('100'));
    }
}
