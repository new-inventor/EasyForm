<?php
/**
 * User: Ionov George
 * Date: 18.03.2016
 * Time: 14:03
 */

return [
    'form' => [
        'template' => '{errors}<div>{formStart}{children}{formEnd}</div>',
    ],
    'block' => [
        'template' => '{label}<div>{children}</div>'
    ],
    'field' => [
        'template' => /** @lang text */'<div><label {forField}>{title}</label>{field}</div>{errors}'
    ],
    'checkSet' => [
        'template' => [
            'set' => '<div>{options}</div>{errors}',
            'option' => '<span><label>{title}{option}</label></span>',
        ],
    ],
    'repeatBlock' => [
        'block' => 'data-repeat-block',
        'container' => 'data-repeat-container',
        'actionsBlock' => 'data-repeat-actions',
        'deleteAction' => 'data-delete',
        'addAction' => 'data-add',
        'template' => [
            'block' => /** @lang text */'<div {selector}>{title}{children}{actions}</div>',
            'container' => /** @lang text */'<div {selector}>{blocks}</div>',
            'actionsBlock' => /** @lang text */'<div {selector}>{delete}{add}</div>',
            'deleteAction' => /** @lang text */'<span {selector}>-</span>',
            'addAction' => /** @lang text */'<span {selector}>+</span>',
        ]
    ],
    'errors' => [
        'delimiter' => '<br>',
        'template' => [
            'field' => '<span>{errors}</span>',
            'block' => '<span>{errors}</span>',
            'form' => '<div>{errors}</div>',
        ]
    ],
    'placeholders' => [
        'available' => [
            'errors',
            'forField',
            'children',
            'handlers',
            'title',
            'label',
            'field',
            'options',
            'option',
            'selector',
            'actions',
            'delete',
            'add',
            'formEnd',
            'formStart',
        ],
        'borders' => ['{', '}']
    ]
];