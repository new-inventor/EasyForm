<?php
/**
 * User: Ionov George
 * Date: 17.03.2016
 * Time: 9:06
 */

return [
    'renderer' => [
        'templates' => [
            'default' => [
                'form' => '{label}<div>{start}{children}{errors}{handlers}{end}</div>',
            ],
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