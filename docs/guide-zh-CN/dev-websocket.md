WebSocket
------

以一个带历史消息的简单聊天室演示如何结合Yii2和Workerman使用Websocket。主体代码参考[Workerman 官方聊天室](https://www.workerman.net/workerman-chat)

### 启动

Windows下双击console\modules\chat\chat.bat

Linux 下执行

```
php yii chat/server start -d  //启动

php yii chat/server status  //查询状态

php yii chat/server -g  //停止 
```

前端启动创建一个store route 为chat，浏览器直接访问网站

### 运行效果

![](https://github.com/funson86/yii2-websocket/blob/master/images/websocket-chat-room.png?raw=true)

/backend/chat/log/index 在后台访问所有的聊天记录

### 实现说明

composer.json中添加 workerman 和 gateway-worker，然后composer update。单独使用workerman也可以，不过要实现网关的功能比较繁琐，直接使用gateway-worker简化网关功能。

```
      "workerman/workerman": "^4.0",
      "workerman/gateway-worker": "^3.0",
```


配置在console\config\params.php中，主要是端口进程配置

```php
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
```

业务代码实现在console\modules\chat\services\Events.php中，主要完成onMessage和onClose函数。将用户聊天消息插入表中，登录时返回最近5条历史消息

### Mysql长连接

console如果不活跃的情况下访问数据库容易出现 “Mysql go away”，连接长时间没交互可能会断掉

使用console\components\Connection 代替yii\db\Connection，在查询前先会判断是否连接是否可用

在console\config\main.php中配置指定类和长连接，在Connection中$attributes = [PDO::ATTR_PERSISTENT => true];指定长连接。

```php
        'db' => [
            'class' => 'console\components\Connection',
        ],
```

### 参考

- [Workerman 官方聊天室](https://www.workerman.net/workerman-chat)
- [简单的Yii Websocket](https://github.com/funson86/yii2-websocket)
