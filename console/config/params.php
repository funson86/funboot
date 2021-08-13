<?php
return [
    'dbBackupPath' => '@console/runtime/backup/',

    'adminEmail' => 'admin@example.com',

    'webBaseUrl' => 'https://funboot.mayicun.com',

    'chat' => [
        'gateway' => [
            'server' => '0.0.0.0',
            'port' => '7272',
            'lanIp' => '127.0.0.1', // 分布式部署时请设置成内网ip（非127.0.0.1）
            'count' => 4, //进程数，gateway进程数建议与cpu核数相同
        ],
        'register' => [
            'server' => '127.0.0.1', // 分布式部署时请设置成内网ip（非127.0.0.1）
            'port' => '1236',
        ],
        'businessworker' => [
            'count' => 4, //进程数，gateway进程数建议与cpu核数相同
        ],
    ]

];
