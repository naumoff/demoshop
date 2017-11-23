<?php
return [
    'top' => [
        'users'=>[
            'link'=>'users',
            'ru'=>'Пользователи'
        ],
        'content'=>[
            'link'=>'content',
            'ru'=>'Контент'
        ],
        'questioners'=>[
            'link'=>'questioners',
            'ru'=>'Опросники'
        ],
        'products'=>[
            'link'=>'products',
            'ru'=>'Товары'
        ]
    ],
    'sidebar'=>[
        'users'=>[
            [
                'link'=>'admin/users/approved',
                'ru'=>'Подтвержденные пользователи'
            ],
            [
                'link'=>'admin/users/pending',
                'ru'=>'Ожидающие регистрации'
            ],
            [
                'link'=>'admin/users/suspended',
                'ru'=>'C приостановленной регистрацией'
            ],
            [
                'link'=>'admin/users/rejected',
                'ru'=>'C отказанной регистрацией'
            ],
            [
                'link'=>'admin/users/all',
                'ru'=>'Все пользователи'
            ],
        ]
    ]
];