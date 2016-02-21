<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 18:29
 */
require 'vendor/autoload.php';

use \NewInventor\EasyForm\AbstractForm;

$form = new AbstractForm('form1', null, AbstractForm::METHOD_POST, 'title1', AbstractForm::ENC_TYPE_MULTIPART);
$form
    ->password('qwee', '123')
        ->title('titleeee')
        ->attribute('class', 'special')
        ->attribute('id', 'qwe1')
    ->end()
    ->text('test', 'qwe')
        ->title('QWE')
        ->attribute('readonly')
        ->attribute('class', 'show')
    ->end()
    ->block('innerBlock')
        ->text('city')
            ->title('Город')
            ->attribute('data-city-input')
        ->end()
        ->select('selectBox1', ['1', '2', '3'])
            ->multiple()
            ->addOptionArray(['1' => 'qwerty', '2' => 'asdfgh', '3' => 'zxcvbn', '4' => 'qazwsx'])
            ->attribute('size', 5)
        ->end()
        ->block('second')
            ->textArea('message', 'input the message here...')
                ->rows(5)
                ->cols(50)
            ->end()
        ->end()
    ->end()
    ->handler(\NewInventor\EasyForm\Handler\AbstractHandler::getClass())
    ->handler(\NewInventor\EasyForm\Handler\ResetHandler::getClass())
->end();
$form->load();
$form->save();
echo $form;