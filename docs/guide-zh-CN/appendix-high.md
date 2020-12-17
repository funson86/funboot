高并发
-----------

### Id生成器

高并发一个重要的部分是系统生成唯一主键ID，在分布式系统中不依赖于mysql主键ID自动生成。Funboot使用雪花算法SlowFlake辅以redis的自增id作为参数结合datacenter、worker支持每秒生成10w+不同ID。

> common/config/params.php中配置如下

```php

    /* 高并发，默认为false, new model 后直接使用 $model->id = IdHelper::snowFlakeId(); */
    'highConcurrency' => false,

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

```php
    $model = new $this->modelClass();
    $model->id = IdHelper::snowFlakeId();
```


### 缓存和Queue使用Redis

系统默认使用File Cache，多台机器的时候需要切换成redis避免文件不一致
