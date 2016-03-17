<head>
    <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
</head>
<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 18:29
 */
require 'vendor/autoload.php';

use \NewInventor\EasyForm\Form;

$form = new Form('form1', null, Form::METHOD_POST, 'title1', Form::ENC_TYPE_MULTIPART);
$form
    ->radioSet('name1', 1)
        ->addOptionArray(['0' => 'value0', '1' => 'value1', '2' => 'value2'])
    ->end()
    ->checkBoxSet('che')
        ->addOptionArray(['value1' => 'title1', 'value2' => 'title2', 'value3' => 'title3'])
    ->end()
    ->checkbox('cccc', false)
        ->attribute('value', 'Yes')
    ->end()
    ->checkbox('cccc3', false)
        ->attribute('value', 'Yes1')
    ->end()
    ->checkbox('cccc4', false)
        ->attribute('value', 'Yes2')
    ->end()
    ->password('qwee', '123')
        ->title('titleeee')
        ->attribute('class', 'special')
        ->attribute('id', 'qwe1')
    ->end()
    ->repeatable(new \NewInventor\EasyForm\Field\Input('testRepeat', '', 'repeat title'))
    ->block('test')
        ->text('0', 'qwe')
            ->title('QWE')
            ->attribute('class', 'show')
            ->validator('string', ['minLength' => 6, 'maxLength' => 12])
            ->validator(
                function ($value){
                    return substr($value, 0, 2) == 'as';
                },
                ['message' => 'Значение поля "{f}" должно начинаться с "as"']
            )
        ->end()
    ->end()
    ->block('innerBlock')
        ->text('city')
            ->title('Город')
            ->validator('required')
            ->validator('integer', ['min' => 5, 'max' => 10])
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
    ->repeatable((new \NewInventor\EasyForm\Block('fullName', 'Полное имя участника.'))
        ->attribute('data-repeatable')
        ->text('name')->end()
        ->text('surname')->end()
        ->text('family')->end())
    ->handler(\NewInventor\EasyForm\Handler\AbstractHandler::getClass())
    ->handler(\NewInventor\EasyForm\Handler\ResetHandler::getClass())
->end();
if($form->load()){
    $form->validate();
    $form->save();
}
echo $form;