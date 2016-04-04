<?php
/**
 * User: Ionov George
 * Date: 17.03.2016
 * Time: 9:06
 */

return [
    'renderer' => [
        'class' =>  NewInventor\Form\Renderer\Renderer::getClass(),
        'templates' => [
            'active' => [
                'field' => /** @lang text */'<span><label {forField}>{title}</label>{field}{errors}</span>',
                'errors' => [
                    'default' => '<span>{errorsStr}</span>',
                ],
                'label' => [
                    'default' => '<div>{title}</div>',
                ],
            ],
        ]
    ],
];