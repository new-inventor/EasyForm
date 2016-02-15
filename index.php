<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 18:29
 */
include $_SERVER['DOCUMENT_ROOT'] . '/NewInventor/EasyForm/vendor/composer/ClassLoader.php';


$dict = new \NewInventor\EasyForm\Abstraction\ObjectList(\NewInventor\EasyForm\Abstraction\KeyValuePair::getClass());

$attr = (new \NewInventor\EasyForm\Abstraction\KeyValuePair('type', 'text', false))->setValueComas('"');
$attr1 = (new \NewInventor\EasyForm\Abstraction\KeyValuePair('readonly', '', true));

$dict->setObjectsDelimiter(' ')->addArray([$attr, $attr1]);
echo $dict;