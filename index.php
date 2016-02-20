<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 18:29
 */
require 'vendor/autoload.php';
use NewInventor\EasyForm\Abstraction\HtmlAttr;

$field = new \NewInventor\EasyForm\Field\Password('test1', '123');
$field->render();

$field1 = new \NewInventor\EasyForm\Field\Select('test2', ['1', '2', '3'], 'title1');
$field1->addOptionArray(['1' => 'qwerty', '2' => 'asdfgh', '3' => 'zxcvbn', '4' => 'qazwsx']);
$field1->attributes()->addArray([
    HtmlAttr::build('multiple'),
    HtmlAttr::build('size', 6),
    HtmlAttr::build('data-method-push')
]);
$field1->render();

$field1 = new \NewInventor\EasyForm\Field\TextArea('test2', 'sdfgsdjf sjdfgajsd fjasg fjksad fjasd fjs kadf sdf asdf sa', 'title1');
$field1->attributes()->addArray([
    HtmlAttr::build('cols', 50),
    HtmlAttr::build('rows', 5)
]);
$field1->render();

$block = new \NewInventor\EasyForm\AbstractBlock('block11', 'title');
$block->text('test1', '123')
    ->setTitle('titleeee')
    ->attributes()
    ->addArray(
        [
            HtmlAttr::build('class', 'special'),
            HtmlAttr::build('id', 'qwe1')
        ]
    );
$block->render();