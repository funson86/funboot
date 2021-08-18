高并发高性能
-----------

目录

- Id生成器
- 缓存使用Redis
- 日志存储到Mongodb中
- Queue使用redis/RabbitMq/Kafka
- 全文索引使用ElasticSearch


### Id生成器

高并发一个重要的部分是系统生成唯一主键ID，在分布式系统中不依赖于mysql主键ID自动生成。Funboot使用雪花算法SlowFlake辅以redis的自增id作为参数结合datacenter、worker支持每秒生成10w+不同ID。

> common/config/params.php中配置如下

```php

    // Snowflake唯一ID
    'snowFlakeUniqueId' => false, // 修改此处不会影响ID顺序，如ID按照15261***开头，修改还是15261***开头，并且按照先后顺序
    'snowFlakeDataCenterId' => 0,
    'snowFlakeWorkerId' => 0,
    'snowFlakeStartAt' => '', //推荐不设置，设置会增加id长度，修改此处会影响ID顺序
    'snowFlakeRedis' => [
        'hostname' => 'localhost',
        'port' => 6379,
        'database' => 0,
    ],
```

- 安装Redis扩展
- 配置snowFlakeUniqueId为true
- 启动redis，且设置snowFlakeRedis
- 多台机器，酌情在params-local中设置dataId和workerId
- 新创建一个model的时候，下一行设置ID，如果不设置，主键虽然设置自增ID，但是冲突的概率理论上是存在的

在系统中的XxxBase如SettingBase.php中将$highConcurrency设置为true，BaseModel的构造函数会自动变更id

```
    /**
     * 是否启用高并发，需要启用的在XxxBase中设置
     * @var bool
     */
    protected $highConcurrency = true;
```

```php
    $model = new $this->modelClass();

    // BaseModel的构造函数会自动变更id
    public function __construct($config = [])
    {
        parent::__construct($config);

        // 高性能
        $this->highConcurrency && $this->id = IdHelper::snowFlakeId();

        // 设置store_id
        (isset($this->store_id) && intval($this->store_id) <= 0) && $this->store_id = Yii::$app->storeSystem->getId();

        $this->on(self::EVENT_AFTER_INSERT, [get_class($this), 'afterInsert']);
        $this->on(self::EVENT_AFTER_UPDATE, [get_class($this), 'afterUpdate']);
        $this->on(self::EVENT_BEFORE_DELETE, [get_class($this), 'beforeDeleteBase']);
    }
```


### 缓存使用Redis

系统默认使用File Cache，单台机器是可行的，多台机器需要做NFS，使用mysql会加重数据库的负担

推荐多台机器的时候需要切换成redis。

修改common/config/main.php

```php
      'components' => [
          'cache' => [
              'class' => 'yii\redis\Cache',
              'redis' => [
                  'hostname' => 'localhost',
                  'port' => 6379,
                  'database' => 0,
              ]
          ],
      ],
```

### 日志存储到Mongodb中

系统支持将日志存储到MongoDb中提升性能，修改common/config/main.php，添加mongodb组件，并将logSystem中的driver改成mongodb。

```php
    'components' => [
        ...
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/funboot',
        ],
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // 是否通过队列方式存数据库
            'driver' => 'mongodb', //'mongodb', // 存储方式，mysql数据库或mongodb数据库
            'levels' => ['error', 'warning'], // 记录日志等级error warning info trace
            'ignoreCodes' => [404], // 忽略错误码
        ],
        ...
    ],
```

> MongoDb 参考文档请查看 https://www.yiiframework.com/extension/yiisoft/yii2-mongodb/doc/guide/2.1/en

> MongoDb 需要独立安装，PHP需要安装MongoDb组件


### Queue使用redis/RabbitMq/Kafka

系统默认使用File Cache，单台机器是可行的，多台机器需要做NFS，使用mysql会加重数据库的负担

推荐多台机器的时候需要切换成redis/RabbitMq/Kafka，根据系统要求和容量选择。

```php
    'bootstrap' => [
        'queue',
    ],
    'components' => [
        'queue'  => [
            'class'   => \yii\queue\redis\Queue::class,
             // 连接组件或它的配置
            'redis'   => 'redis',
           // Queue channel key
            'channel' => 'queue',
            
        ],
        'redis'  => [
            'class'    => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port'     => 6379,
            'database' => 0,
        ]
    ]
```

### 全文索引使用ElasticSearch

修改common/config/main.php，添加mongodb组件，

启动Elasticsearch，默认会监听9200端口

```php
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
            'dslVersion' => 7, // default is 5
        ],
```



