<?php

use Phalcon\Config;

return new Config([
    'visitor' => [
        'index' => ['public'],
        'features' => ['public'],
        'faqs' => ['public'],
        'terms' => ['public'],
        'contact' => ['public', 'submitData'],
        'unsuscribe' => ['public', 'submitData'],
        'captcha' => ['generateCaptcha'],
        'profile' => ['register', 'login', 'recover', 'finishRecover'],
        'errors' => ['show404', 'show503'],
        'language' => ['change']
    ],
    'limited' => [
        'index' => ['public'],
        'features' => ['public'],
        'faqs' => ['public'],
        'terms' => ['public'],
        'contact' => ['public', 'submitData'],
        'unsuscribe' => [],
        'captcha' => ['generateCaptcha'],
        'profile' => ['logout', 'updateTempProfile','verify', 'finishVerify'],
        'errors' => ['show404', 'show503'],
        'language' => ['change']
    ],
    'admin' => [
        'index' => ['*'],
        'features' => ['*'],
        'faqs' => ['*'],
        'terms' => ['*'],
        'contact' => ['*'],
        'unsuscribe' => ['*'],
        'captcha' => ['*'],
        'options' => ['index'],
        'messages' => ['*'],
        'profile' => [
            'index',
            'logout',
            'updateAlias',
            'updateEmail',
            'finishUpdateEmail',
            'updatePassword',
            'finishUpdatePassword',
            'delete',
            'finishDelete'
        ],
        'errors' => ['show404', 'show503'],
        'language' => ['change']
    ]
]);
