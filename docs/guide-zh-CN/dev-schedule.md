定时任务
-----------

> 注意需要在Linux环境下运行，且让PHP的system函数取消禁用


Funboot可以在后台管理定时任务，默认有一条数据库备份的定时任务每天凌晨三点执行

![](images/schedule-01.png)


在系统的crontab中增加一条定时程序

```
* * * * * php /www/funboot/yii yii schedule/run --scheduleFile=/www/funboot/runtime/schedule/schedule.php 1>> /dev/null 2>&1
```


默认路径在common/config/params.php中配置，可修改路径重新生成，crontab也需要一并修改
```php
    // 定时任务存储路径
    'scheduleFile' => '@console/runtime/schedule/schedule.php',
```


```
Linux
*    *    *    *    *    *
-    -    -    -    -    -
|    |    |    |    |    |
|    |    |    |    |    + year [可选]
|    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
|    |    |    +---------- month (1 - 12)
|    |    +--------------- day of month (1 - 31)
|    +-------------------- hour (0 - 23) 
+------------------------- min (0 - 59)
```


### 参考

- [yii2-scheduling](https://github.com/omnilight/yii2-scheduling): 定时任务
