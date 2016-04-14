<?php
/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 14:03
 */

return [
    'templates' => [
        'default' => [
            'form' => '{resultMessage}{errors}{label}<div>{start}{children}{handlers}{end}</div>',
            'block' => '{label}<div>{children}</div>',
            'field' => /** @lang text */'<div><label {forField}>{title}</label>{field}</div>{errors}',
            'handler' => '<div>{handler}</div>',
            'errors' => [
                'default' => '<span>{errorsStr}</span>',
                'form' => '<div>{errorsStr}</div>',
            ],
            'label' => [
                'default' => '<span>{title}</span>',
                'form' => '<div>{title}</div>',
            ],
            'resultMessage' => '<',
            'checkSet' => '{label}<div>{options}</div>{errors}',
            'checkSetOption' => '<span><label>{optionTitle}{option}</label></span>',
            'repeatFiled' => /** @lang text */'<div {blockSelector}>{field}{actions}{errors}</div>',
            'repeatBlock' => /** @lang text */'<div {blockSelector}>{children}{actions}</div>',
            'repeatContainer' => /** @lang text */'<div {containerSelector}>{label}{children}</div>{repeatScript}',
            'repeatActionsBlock' => /** @lang text */'<div {actionsBlockSelector}="{name}">{deleteButton}{addButton}</div>',
            'deleteButton' => /** @lang text */'<span {deleteActionSelector}>-</span>',
            'addButton' => /** @lang text */'<span {addActionSelector}>+</span>',
            'attribute' => '{name}="{value}"',
            'shortAttribute' => '{name}'
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
        \NewInventor\Form\Form::getClass() => 'form',
        \NewInventor\Form\Block::getClass() => 'block',
        \NewInventor\Form\Field\AbstractField::getClass() => 'field',
        \NewInventor\Form\Handler::getClass() => 'handler',
    ]
];