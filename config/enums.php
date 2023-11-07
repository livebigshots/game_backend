<?php

return [
    'IS_SOCIAL_MEDIA_USER' => [
        'YES' => 1,
        'NO' => 0,
    ],

    'FILE_TYPE' => [
        0 => 'COW/VACCINATIONS',
        1 => 'COW/DOCUMENTS',
        2 => 'COW/PROFILES',
        3 => 'COW_LOT/VACCINATIONS',
        4 => 'COW_LOT/DOCUMENTS',
        5 => 'COW_LOT/PROFILES'
    ],

    'USER_TYPE' => [
        'ADMIN' => 1,
        'USER' => 2,
    ],

    'COW_TYPE' => [
        'COW' => 0,
        'COW_LOT' => 1,
    ],

    'OS_TYPE' => [
        'ANDROID',
        'IOS',
    ],

    'COW_PAYMENT_STATUS' => [
        'PENDING' => 0,
        'VERIFIED' => 1,
        'DECLINED' => 2,
    ],

    'IS_PAYMENT_ACCEPTED' => [
        'NO' => 0,
        'YES' => 1,
    ],

    'PAYMENT_STATUS' => [
        'NOT_RECEIVED' => 0,
        'RECEIVED' => 1,
        'REFUNDED' =>2
    ],

    'IS_NOTIFICATION_ENABLED' => [
        'NO' => 0,
        'YES' => 1,
    ],

    'PAYMENT_TYPE' => [
        'SUCCESS' => 0,
        'REFUNDED' => 1,
        'FAILED' => 2
    ]
];
