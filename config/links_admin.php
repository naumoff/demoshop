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
        
        'presents'=>[
            'link'=>'/admin/presents',
            'ru'=>'Подарки'
        ],
        
        'sales'=>[
            'link'=>'/admin/sales',
            'ru'=>'Продажи'
        ],
        
        'partners'=>[
            'link'=>'/admin/partners',
            'ru'=>'Платежные партнеры'
        ],
    
        'questioners'=>[
            'link'=>'/admin/questioners',
            'ru'=>'Опросники'
        ],
        
        'content'=>[
            'link'=>'/admin/content',
            'ru'=>'Контент'
        ],

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
                'link'=>'/admin/products/{cat_id}/groups',
                'ru'=>'Группы'
            ],

            [
                'link'=>'/admin/products/{cat_id}/{group_id}/products',
                'ru'=>'Товары'
            ],
            
            [
                'link'=>'/admin/products/create-currency-rate',
                'ru'=>'Курс валют'
            ]
        ],
        'packages'=>[
            [
                'link'=> '/admin/packages/create',
                'ru'=>'Добавить комплект'
            ],
            [
                'link'=>'/admin/packages',
                'ru'=>'Управление комплектами'
            ],
        ],
        'presents'=>[
            [
                'link'=> '/admin/presents/create',
                'ru'=>'Добавить подарок'
            ],
            [
                'link'=>'/admin/presents',
                'ru'=>'Управление подарками'
            ],
        ],
        'sales'=>[
            [
                'link'=>'/admin/sales/orders',
                'ru'=>'Управление заказами'
            ],
            [
                'link'=>'/admin/sales/invoices',
                'ru'=>'Управление инвойсами'
            ],
            [
                'link'=> '/admin/sales/deliveries',
                'ru'=>'Стоимость доставки'
            ],
        ],
        
        'partners'=>[
            [
                'link'=> '/admin/partners/create',
                'ru'=>'Добавить партнера'
            ],
            [
                'link'=>'/admin/partners',
                'ru'=>'Управление партнерами'
            ],
        ]
    ]
];