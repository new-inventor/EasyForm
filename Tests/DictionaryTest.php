<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 17:18
 */

namespace NewInventor\EasyForm\Tests;

use NewInventor\EasyForm\Abstraction\Dictionary;
use NewInventor\EasyForm\Abstraction\KeyValuePair;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $attr1 = new KeyValuePair('type', 'text', false);
        $attr1->setDelimiter('=')->setNameComas('')->setValueComas('\'');
        $attr2 = new KeyValuePair('attach', 'value', false);
        $attr2->setDelimiter(': ')->setNameComas('')->setValueComas('\'');
        $dict = new Dictionary(get_class($attr1));
        $dict->setPairDelimiter(' => ')->add($attr1)->add($attr2);
        $this->assertEquals('type=\'text\'', $dict->get('type')->getString());
        $this->assertEquals('attach: \'value\'', $dict->get('attach')->getString());

        $this->assertEquals('type=\'text\' => attach: \'value\'', $dict->getString());
    }
}
