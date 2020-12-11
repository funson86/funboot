质量保证
-----------

### Codesniffer

高并发一个重要的部分是系统生成唯一主键ID，在分布式系统中不依赖于mysql主键ID自动生成。Funboot使用雪花算法SlowFlake辅以redis的自增id作为参数结合datacenter、worker支持每秒生成10w+不同ID。

> common/config/params.php中配置如下

```
composer require "squizlabs/php_codesniffer=*"

./vendor/bin/phpcs ./api
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


参考
https://www.jianshu.com/p/d979ae1e7e57
