<?php
/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 14:03
 */

return [
    'form' => [
        'template' => '{errors}<div>{formStart}{children}{formEnd}</div>'
    ],
    'block' => [
        'template' => '{label}<div>{children}</div>'
    ],
    'field' => [
        'template' => '<div>{label}{field}</div>{errors}'
    ],
    'error' => [
        'template' => [
            'field' => '<span>{errors}</span>',
            'block' => '<span>{errors}</span>',
            'form' => '<div>{errors}</div>',
            'delimiter' => '<br>',
        ]
    ],
    'label' => [
        'template' => [
            'field' => /** @lang text */'<label {forField}>{title}</label>',
            'block' => '<div>{label}</div>'
        ]
    ],
    'radioSet' => [
        'template' => [
            'radioset' => '<div>{options}{errors}</div>',
            'option' => '<span>{label}{option}</span>'
        ]
    ],
    'checkBoxSet' => [
        'template' => [
            'radioset' => '<div>{options}{errors}</div>',
            'option' => '<span>{label}{option}</span>'
        ],
        'placeholders' => [

        ]
    ],
    'repeatBlock' => [
        'block' => 'data-repeat-block',
        'container' => 'data-repeat-container',
        'actionsBlock' => 'data-repeat-actions',
        'deleteAction' => 'data-delete',
        'addAction' => 'data-add',
        'template' => [
            'block' => /** @lang text */'<div {selector}>{children}{actions}</div>',
            'container' => /** @lang text */'<div {selector}>{blocks}</div>',
            'actionsBlock' => /** @lang text */'<div {selector}>{delete}{add}</div>',
            'deleteAction' => /** @lang text */'<span {selector}>-</span>',
            'addAction' => /** @lang text */'<span {selector}>+</span>',
        ]
    ],
    'placeholder' => [
        'errors' => 'errors',
        'forField' => 'forField',
        'children' => 'children',
        'handlers' => 'handlers',
        'title' => 'title',
        'label' => 'label',
        'field' => 'field',
        'options' => 'options',
        'option' => 'option',
        'selector' => 'selector',
        'actions' => 'actions',
        'delete' => 'delete',
        'add' => 'add',
    ]
];