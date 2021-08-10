<?php
return [
    'adminEmail' => 'admin@example.com',

    //速率限制，如 100s 内 20 次，可以在param.php中设置频率
    'rateLimit' => 20,
    'timeLimit' => 100,

    'user' => [
        // token有效期是否验证
        'accessTokenValid' => true,
        // token缓存有效期
        'accessTokenExpired' => 2 * 3600,
    ]
];
