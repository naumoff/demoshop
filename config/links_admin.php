<?php
return [
    'top' => [
        'users'=>[
            'link'=>'/admin/users',
            'ru'=>'Пользователи'
        ],
    
        'products'=>[
            'link'=>'/admin/products',
            'ru'=>'Товары'
        ],
        
        'packages'=>[
            'link'=>'/admin/packages',
            'ru'=>'Комплекты'
        ],
        
        'orders'=>[
            'link'=>'/admin/orders',
            'ru'=>'Заказы'
        ],
        
        'content'=>[
            'link'=>'/admin/content',
            'ru'=>'Контент'
        ],
        'questioners'=>[
            'link'=>'/admin/questioners',
            'ru'=>'Опросники'
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
        ],
        'products'=>[
            [
                'link'=>'/admin/products/categories',
                'ru'=>'Категории'
            ],
            [
                'link'=>'/admin/products/groups',
                'ru'=>'Группы'
            ],
            [
                'link'=>'/admin/products/products',
                'ru'=>'Товары'
            ]
        ]
    ]
];