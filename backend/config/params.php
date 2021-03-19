<?php
return [
    'adminEmail' => 'admin@example.com',

    // 无需鉴权的url路径，需要以/开头
    'ignoreUrlList' => [
        '/site/*', //自身判断是否登录
        '/message/*', //自身判断是否登录
        '/swagger/*', //公开
        '/ueditor/*', //百度编辑器，有文件本身判断是否登录
        '/file/*', //文件上传相关，有文件本身判断是否登录
    ],

    // Swagger扫描api的路径
    'swaggerScanPath' => [
        '@api/controllers',
        '@api/modules/mini/controllers',
        '@api/modules/v1/controllers',
        '@api/modules/v2/controllers',
    ],

    'helpUrl' => [
        'en' => [
            'Coupon Types' => '',
        ],
        'zh-CN' => [
            'Coupon Types' => '',
        ],
    ]
];
