<?php
return [
    'top' => [
        'users'=>[
            'link'=>'/admin/users',
            'ru'=>'Пользователи'
        ],
        'content'=>[
            'link'=>'/admin/content',
            'ru'=>'Контент'
        ],
        'questioners'=>[
            'link'=>'/admin/questioners',
            'ru'=>'Опросники'
        ],
        'products'=>[
            'link'=>'/admin/products',
            'ru'=>'Товары'
        ]
    ],
    'sidebar'=>[
        'users'=>[
            [
                'link'=>'/admin/users/approved',
                'ru'=>'Подтвержденные пользователи'
            ],
            [
                'link'=>'/admin/users/pending',
                'ru'=>'Ожидающие регистрации'
            ],
            [
                'link'=>'/admin/users/suspended',
                'ru'=>'C приостановленной регистрацией'
            ],
            [
                'link'=>'/admin/users/rejected',
                'ru'=>'C отказанной регистрацией'
            ],
            [
                'link'=>'/admin/users/all',
                'ru'=>'Все пользователи'
            ],
        ]
    ]
];