<?php
return [
    'adminEmail' => 'admin@example.com',

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
    ]
];
