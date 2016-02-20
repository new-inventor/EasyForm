<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 17:18
 */

namespace NewInventor\EasyForm\Tests;

use NewInventor\EasyForm\Abstraction\HtmlAttr;
use NewInventor\EasyForm\Abstraction\NamedObjectList;
use NewInventor\EasyForm\Abstraction\KeyValuePair;
use NewInventor\EasyForm\Exception\ArgumentTypeException;

class ObjectListTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $attr1 = new KeyValuePair('type', 'text', false);
        $attr1->setDelimiter('=')->setNameComas('')->setValueComas('\'');
        $attr2 = new KeyValuePair('attach', 'value', false);
        $attr2->setDelimiter(': ')->setNameComas('')->setValueComas('\'');
        $dict = new NamedObjectList([get_class($attr1)]);
        $dict->setObjectsDelimiter(' => ')->add($attr1)->add($attr2);
        $this->assertEquals('type=\'text\'', $dict->get('type')->render());
        $this->assertEquals('attach: \'value\'', $dict->get('attach')->render());

        $this->assertEquals('type=\'text\' => attach: \'value\'', $dict->render());
    }

    public function testGet()
    {
        $list = new NamedObjectList([KeyValuePair::getClass()]);
        $list->add(HtmlAttr::build('name', 'val'));
        $this->assertEquals('name="val"', $list->get('name')->render());
        $this->assertNull($list->get('hearer'));
        $this->setExpectedException('NewInventor\EasyForm\Exception\ArgumentTypeException');
        $list->get(new KeyValuePair('dfsd'));
        $list->get(null);
    }
}
