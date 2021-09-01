WebSocket - 带历史消息的聊天室
------

以一个带历史消息的简单聊天室演示如何结合Yii2和Workerman使用Websocket以及和数据库交互。主体代码参考[Workerman 官方聊天室](https://www.workerman.net/workerman-chat)

### 演示地址

- https://chat.funboot.net/

### 启动

Windows下双击console\modules\chat\chat.bat

Linux 下执行

```
# php yii chat/server start -d
Workerman[yii] start in DAEMON mode
----------------------------------------------- WORKERMAN -----------------------------------------------
Workerman version:4.0.19          PHP version:7.3.23
------------------------------------------------ WORKERS ------------------------------------------------
proto   user            worker                listen                       processes    status           
tcp     root            Register              text://127.0.0.1:1236        1             [OK]            
tcp     root            ChatGateway           websocket://0.0.0.0:7272)    4             [OK]            
tcp     root            ChatBusinessWorker    none                         4             [OK]            
---------------------------------------------------------------------------------------------------------
Input "php yii chat/server stop" to stop. Start success.

# php yii chat/server stop // 停止
# php yii chat/server stop -g  //优雅停止 

# php yii chat/server restart -d //重启 
# php yii chat/server reload -d //重启（重新加载执行代码，不加载配置） 

# php yii chat/server status  //查询状态
# php yii chat/server connections  //连接

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

### WSS安全连接

如果前端网站是https，会要求使用安全的wss。提示：

修改nginx的https配置，将/wss指向
```
server
    {
        listen 443 ssl http2;

        ...

        location /wss {
             #access_log /usr/share/nginx/logs/https-websocket.log;
             proxy_pass http://127.0.0.1:7272/; # 代理到上面              
             proxy_set_header X-Real-IP $remote_addr;
             proxy_set_header Host $host;
             proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
             proxy_http_version 1.1;
             proxy_set_header Upgrade $http_upgrade;
             proxy_set_header Connection "upgrade";
             rewrite /wss/(.*) /$1 break;
             proxy_redirect off;
        }
    }
```

修改前端链接地址如web/resources/chat/default/views/default/index.php

```js
ws = new WebSocket("wss://"+document.domain+"/wss");
```

### 参考

- [Workerman 官方聊天室](https://www.workerman.net/workerman-chat)
- [简单的Yii Websocket](https://github.com/funson86/yii2-websocket)
