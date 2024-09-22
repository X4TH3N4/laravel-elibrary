<?php

return [

    'title' => 'Parolanızı Sıfırlayın',

    'heading' => 'Parolanızı Sıfırlayın',

    'form' => [

        'email' => [
            'label' => 'E-posta adresi',
        ],

        'password' => [
            'label' => 'Parola',
            'validation_attribute' => 'parola',
        ],

        'password_confirmation' => [
            'label' => 'Parolayı Onayla',
        ],

        'actions' => [

            'reset' => [
                'label' => 'Parolayı Sıfırla',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Çok fazla sıfırlama denemesi',
            'body' => ':seconds saniye sonra tekrar deneyin.',
        ],

    ],

];
