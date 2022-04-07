<?php
return [
    'adminEmail' => 'admin@example.com',

    // 无需鉴权的url路径，需要以/开头
    'ignoreUrlList' => [
        '/site/*', //自身判断是否登录
        '/base/msg/*', //消息
        '/base/recharge/*', //充值
        '/base/fund-log/*', //充值
        '/base/invoice/*', //发票
        '/swagger/*', //公开
        '/ueditor/*', //百度编辑器，有文件本身判断是否登录
        '/file/*', //文件上传相关，有文件本身判断是否登录
    ],

    // Swagger扫描api的路径
    'swaggerScanPath' => [
        '@api/controllers',
    ],

    'helpUrl' => [
        'en' => [
            'Coupon Types' => '',
            'school_student' => 'https://github.com/funson86/funboot/blob/master/README.md',
            'school_teacher' => 'https://github.com/funson86/funboot/blob/master/docs/guide/README.md',
        ],
        'zh-CN' => [
            'Coupon Types' => '',
            'school_student' => 'https://github.com/funson86/funboot/blob/master/README_zh-CN.md',
            'school_teacher' => 'https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/README.md',
        ],
    ]
];
