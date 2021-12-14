WebSocket - Chat room with history message
------

A Demo of chat room with history message show how to interact with websocket and mysql by using Yii2 and Workerman. Most code refer to [Workerman official Chat Room](https://www.workerman.net/workerman-chat)

### Demo

- https://chat.funboot.net/

### Running

Windows: Double click console\modules\chat\chat.bat

Linux: Run command

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

# php yii chat/server stop // Stop
# php yii chat/server stop -g  // Stop gracefully 

# php yii chat/server restart -d // Restart 
# php yii chat/server reload -d // Reload (Reload executing code without config) 

# php yii chat/server status  // query status
# php yii chat/server connections  // query connnections

```

Creat an store with route chat in the backend. then access website by browser

### Snapshot

![](https://github.com/funson86/yii2-websocket/blob/master/images/websocket-chat-room.png?raw=true)

/backend/chat/log/index The url to access history message 

### Explain

Add workerman and gateway-worker in composer.json, then run "composer update". This use gateway-worker to complete the gateway function, you can complete the gateway yourself if you do not want use workerman gateway.

```
      "workerman/workerman": "^4.0",
      "workerman/gateway-worker": "^3.0",
```


Config port and process in console\config\params.php

```php
    'chat' => [
        'gateway' => [
            'server' => '0.0.0.0',
            'port' => '7272',
            'lanIp' => '127.0.0.1', // distributed pls config intranet iP（not 127.0.0.1）
            'count' => 4, // process count，should be equal to cpu core count
        ],
        'register' => [
            'server' => '127.0.0.1', // distributed pls config intranet iP（not 127.0.0.1）
            'port' => '1236',
        ],
        'businessworker' => [
            'count' => 4, // process count，should be equal to cpu core count
        ],
    ]
```

Business code is in console\modules\chat\services\Events.php, complete onMessage and onClose function. Insert use message to database, return the lastest 5 message after use login.

### Mysql persistent connection

"Mysql go away" will be returned by Mysql to the client of console for a long time without interaction, for Msyql server will disconnect the client. 

Use console\components\Connection instead of yii\db\Connection, it will check the connection active or not before operation.

Config in console\config\main.php, The code $attributes = [PDO::ATTR_PERSISTENT => true] specify persistent connection in Connection

```php
        'db' => [
            'class' => 'console\components\Connection',
        ],
```

### WSS Security Connection

If the frontend website use https, it requires wss.

Modify config in nginx, let /wss to proxy

```
server
    {
        listen 443 ssl http2;

        ...

        location /wss {
             #access_log /usr/share/nginx/logs/https-websocket.log;
             proxy_pass http://127.0.0.1:7272/; # proxy              
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

Modify the address in web/resources/chat/default/views/default/index.php of frontend.

```js
ws = new WebSocket("wss://"+document.domain+"/wss");
```

### References

- [Workerman official Chat Room](https://www.workerman.net/workerman-chat)
- [Simple Yii Websocket](https://github.com/funson86/yii2-websocket)
