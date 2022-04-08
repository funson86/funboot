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
            'base_setting_50' => '/help/en/',
            'school_student' => 'https://github.com/funson86/funboot/blob/master/README.md',
            'school_teacher' => 'https://github.com/funson86/funboot/blob/master/docs/guide/README.md',
            'tool_qr' => '/help/en/',
            'tool_crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide/dev-gii.md',
            'tool_cruds' => 'https://github.com/funson86/funboot/blob/master/docs/guide/dev-gii.md',
            'tool_tree' => 'https://github.com/funson86/funboot/blob/master/docs/guide/dev-gii.md',
            'tool_mongodb-crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide/3rd-mongodb.md',
            'tool_redis-crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide/3rd-redis.md',
            'tool_elasticsearch-crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide/3rd-elasticsearch.md',
        ],
        'zh-CN' => [
            'base_setting_50' => '/help/zh-CN/',
            'school_student' => 'https://github.com/funson86/funboot/blob/master/README_zh-CN.md',
            'school_teacher' => 'https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/README.md',
            'tool_qr' => '/help/zh-CN/',
            'tool_crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide/dev-gii.md',
            'tool_cruds' => 'https://github.com/funson86/funboot/blob/master/docs/guide/dev-gii.md',
            'tool_tree' => 'https://github.com/funson86/funboot/blob/master/docs/guide/dev-gii.md',
            'tool_mongodb-crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/3rd-mongodb.md',
            'tool_redis-crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/3rd-redis.md',
            'tool_elasticsearch-crud' => 'https://github.com/funson86/funboot/blob/master/docs/guide-zh-CN/3rd-elasticsearch.md',
        ],
    ]
];
