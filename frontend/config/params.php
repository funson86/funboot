<?php
return [
    'adminEmail' => 'admin@example.com',

    'oauth' => [
        'user' => [
            // 授权码code过期时间为10分钟
            'codeExpired' => 'PT10M',

            // access token有效期是否验证
            'accessTokenValid' => true,
            // access token缓存有效期48小时
            'accessTokenExpired' => 'PT48H',

            // refresh token有效期是否验证
            'refreshTokenValid' => true,
            // refresh token缓存有效期1个月
            'refreshTokenExpired' => 'P1M',
        ],
    ],

    'bannerUrls' => [
        '/',
        '/site',
        '/site/index',
        '/site/info',
    ],
];
