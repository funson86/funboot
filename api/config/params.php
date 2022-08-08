<?php
return [
    'adminEmail' => 'admin@example.com',

    // 无需鉴权的url路径，需要以/开头
    'ignoreUrlList' => [
        '/site/*', //自身判断是否登录
        '/food/default/login', //自身判断是否登录
    ],

    //速率限制，如 100s 内 20 次，可以在param.php中设置频率
    'rateLimit' => 20,
    'timeLimit' => 100,

    'user' => [
        // access token有效期是否验证
        'accessTokenValid' => true,
        // access token缓存有效期
        'accessTokenExpired' => 2 * 3600,

        // refresh token有效期是否验证
        'refreshTokenValid' => true,
        // refresh token缓存有效期
        'refreshTokenExpired' => 30 * 24 * 3600,
    ],

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
        'oauthRsaPublic' => '@common/config/oauth2_public.key',
        'oauthRsaPrivate' => '@common/config/oauth2_private.key',
    ],

];
