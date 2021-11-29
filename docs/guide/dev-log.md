系统日志组件
-----------

目录
- 系统日志
- 使用MongoDb存储日志

### 系统日志 

系统日志分为操作日志、错误日志、登录日志、数据库日志、控制台日志、邮件日志。

- 操作日志，监控数据表更新，凡是有更新均会记录
- 错误日志，系统报错时产生，日志等级error warning info trace，可以在配置中指定
- 登录日志，用户登录时候记录
- 数据库日志，开发人员在代码中记录，方便在后台查看
- 控制台日志，开发人员在控制台代码中记录，方便在后台查看
- 邮件日志，使用mailSystem发送邮件时会自动记录，也可以手动记录


common/config/main.php
```
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // 是否通过队列方式存数据库
            'driver' => 'mysql', //'mongodb', // 存储方式，mysql数据库或mongodb数据库
            'levels' => ['error', 'warning'], // 记录日志等级error warning info trace
            'ignoreCodes' => [404], // 忽略错误码
        ],
```

### 使用MongoDb存储日志

参考 [高并发高性能](appendix-high.md) 中 日志存储到Mongodb中小节
