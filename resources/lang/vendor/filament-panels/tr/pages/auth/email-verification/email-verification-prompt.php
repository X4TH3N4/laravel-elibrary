<?php

return [

    'title' => 'E-posta adresinizi doğrulayın',

    'heading' => 'E-posta adresinizi doğrulayın',

    'actions' => [

        'resend_notification' => [
            'label' => 'Yeniden gönder',
        ],

    ],

    'messages' => [
        'notification_not_received' => 'Gönderdiğimiz e-postayı almadınız mı?',
        'notification_sent' => 'E-posta adresinizi doğrulama talimatlarını içeren bir e-posta, :email adresine gönderildi.',
    ],

    'notifications' => [

        'notification_resent' => [
            'title' => 'E-postayı tekrar gönderdik.',
        ],

        'notification_resend_throttled' => [
            'title' => 'Çok fazla yeniden gönderme denemesi',
            'body' => 'Lütfen :seconds saniye sonra tekrar deneyin.',
        ],

    ],

];
