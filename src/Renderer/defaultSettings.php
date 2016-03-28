<?php
/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 14:03
 */

return [
    'templates' => [
        'default' => [
            'form' => '{errors}{label}<div>{formStart}{children}{handlers}{formEnd}</div>',
            'block' => '{label}<div>{children}</div>',
            'field' => /** @lang text */'<div><label {forField}>{title}</label>{fieldStr}</div>{errors}',
            'handler' => '<div>{handlerStr}</div>',
            'errors' => [
                'default' => '<span>{errorsStr}</span>',
                'form' => '<div>{errorsStr}</div>',
            ],
            'label' => [
                'default' => '<span>{title}</span>',
                'form' => '<div>{title}</div>',
            ],
            'checkSet' => '<div>{options}</div>{errors}',
            'checkSetOption' => '<span><label>{optionTitle}{option}</label></span>',
            'repeatFiled' => /** @lang text */'<div {blockSelector}>{fieldStr}{actions}{errors}</div>',
            'repeatBlock' => /** @lang text */'<div {blockSelector}>{children}{actions}</div>',
            'repeatContainer' => /** @lang text */'<div {containerSelector}>{label}{children}</div>{repeatScript}',
            'repeatActionsBlock' => /** @lang text */'<div {actionsBlockSelector}="{name}">{deleteButton}{addButton}</div>',
            'deleteButton' => /** @lang text */'<span {deleteActionSelector}>-</span>',
            'addButton' => /** @lang text */'<span {addActionSelector}>+</span>',
            'attribute' => '{name}="{value}"'
        ],
    ],
    'repeat' => [
        'block' => 'data-repeat-block',
        'container' => 'data-repeat-container',
        'actionsBlock' => 'data-repeat-actions',
        'deleteAction' => 'data-delete',
        'addAction' => 'data-add',
    ],
    'errors' => [
        'delimiter' => '<br>',
    ],
    'placeholders' => [
        'borders' => ['{', '}']
    ],
    'alias' => [
        \NewInventor\EasyForm\Form::getClass() => 'form',
        \NewInventor\EasyForm\Block::getClass() => 'block',
        \NewInventor\EasyForm\Field\AbstractField::getClass() => 'field',
        \NewInventor\EasyForm\Handler\AbstractHandler::getClass() => 'handler',
    ]
];