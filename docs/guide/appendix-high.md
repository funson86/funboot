High Concurrency & Performance
-----------

Table of contents

- Id Generator
- Cache use Redis
- Save log in Mongodb
- Queue use redis/RabbitMq/Kafka
- Full text index use ElasticSearch


If use Mongodb or elasticsearch, add code below in composer.json and composer update. And the mongodb and elasticsearch should be installed.

```php
        "yiisoft/yii2-mongodb": "^2.1",
        "yiisoft/yii2-elasticsearch": "~2.1.0",
```

### Id Generator

While High Concurrency, It may id conflict in mysql, while distributed system Funboot use SlowFlake with redis auto increasing id, datacenter and worker, It can support 10w+ unique id every second.

> config in common/config/params.php

```php

    // Snowflake unique ID
    'snowFlakeUniqueId' => false, // whether use unique id or not
    'snowFlakeDataCenterId' => 0,
    'snowFlakeWorkerId' => 0,
    'snowFlakeStartAt' => '', // Recommend blank, will increase id length. modify will affect id sequence
    'snowFlakeRedis' => [
        'hostname' => 'localhost',
        'port' => 6379,
        'database' => 0,
    ],
```

- Install Redis extension
- config snowFlakeUniqueId to true
- Start redis, and config snowFlakeRedis
- If multiple server, config dataId and workerId in params-local.php
- When a new model is created, the ID is set in the next row. If it is not set, the primary key is set with the self increasing ID, but the probability of conflict exists in theory.

Set $highConcurrency to true in XxxBase, eg: SettingBase.php, the id will change in construct in BaseModel

```
    /**
     * Enable or not, in model file XxxBase.php
     * @var bool
     */
    protected $highConcurrency = true;
```

```php
    $model = new $this->modelClass();

    // change id in BaseModel construct 
    public function __construct($config = [])
    {
        parent::__construct($config);

        // high concurrency
        $this->highConcurrency && $this->id = IdHelper::snowFlakeId();

        // set store_id without table store
        if (!$this instanceof Store) {
            $this->store_id = Yii::$app->storeSystem->getId();
        }

        $this->on(self::EVENT_AFTER_INSERT, [get_class($this), 'afterInsert']);
        $this->on(self::EVENT_AFTER_UPDATE, [get_class($this), 'afterUpdate']);
        $this->on(self::EVENT_BEFORE_DELETE, [get_class($this), 'beforeDeleteBase']);
    }
```


### Cache Redis

Funboot use File Cache as cache driver by default on a single server. Multiple servers can use NFS/Mysql/Redis. Recommend redis.

Edit common/config/main.php

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

### Save log in Mongodb

The system supports storing logs in mongodb to improve performance by modifying common/config/main.php, adding mongodb components, and changing the driver in logSystem to mongodb.

```php
    'components' => [
        ...
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/funboot',
        ],
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // use queue or not
            'driver' => 'mongodb', //'mongodb', // driver, mysql or mongodb
            'levels' => ['error', 'warning'], // log level: error warning info trace
            'ignoreCodes' => [404], // ignore codes
        ],
        ...
    ],
```

> MongoDb Document refer to https://www.yiiframework.com/extension/yiisoft/yii2-mongodb/doc/guide/2.1/en

> MongoDb and php mongodb extension need to be installed. 


### Queue use redis/RabbitMq/Kafka

Funboot use File Cache as cache driver by default on a single server. Multiple servers can use NFS/Mysql/Redis. 

Recommend redis redis/RabbitMq/Kafka in Multiple Servers based on requirements.

```php
    'bootstrap' => [
        'queue',
    ],
    'components' => [
        'queue'  => [
            'class'   => \yii\queue\redis\Queue::class,
             // component and setting
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

### Full text index use ElasticSearch

Add mongodb Component in common/config/main.php.

Start Elasticsearch, it listens to port 9200 by default.

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

### Other

- Enable schema cache for mysql.

```
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=funboot',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'tablePrefix' => 'fb_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 86400,
            'schemaCache' => 'cache',
        ],
```

- Not save operation log

In common/config/main-local.php set 'types' => ['login', 'db', 'error', 'console', 'mail'], delete 'operation'

```
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => true,
            'driver' => 'mongodb', // driver type, mysql or mongodb
            'levels' => ['error', 'warning'],
            'types' => [/*'operation', */'login', 'db', 'error', 'console', 'mail'], // without opeartion
            'ignoreCodes' => [404], // 忽略错误码
        ],

```
