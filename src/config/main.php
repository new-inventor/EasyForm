<?php
/**
 * User: Ionov George
 * Date: 17.03.2016
 * Time: 9:06
 */

return [
    'renderer' => [
        'class' => 'NewInventor\EasyForm\Renderer\Renderer',
        'form' => [
            'template' => '{errors}<div>{children}</div>'
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
        'radioSetOption' => [
            'template' => /** @lang text */'{label}{option}'
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
        ]
    ],
];