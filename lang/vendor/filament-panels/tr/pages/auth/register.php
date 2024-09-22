<?php

return [

    'title' => 'Kayıt Ol',

    'heading' => 'Üye Ol',

    'actions' => [

        'login' => [
            'before' => 'veya',
            'label' => 'hesabınıza giriş yapın',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'E-posta adresi',
        ],

        'name' => [
            'label' => 'İsim',
        ],

        'password' => [
            'label' => 'Parola',
            'validation_attribute' => 'parola',
        ],

        'password_confirmation' => [
            'label' => 'Parolayı Onayla',
        ],

        'actions' => [

            'register' => [
                'label' => 'Üye Ol',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Çok fazla kayıt denemesi',
            'body' => 'Lütfen :seconds saniye sonra tekrar deneyin.',
        ],

    ],

];
