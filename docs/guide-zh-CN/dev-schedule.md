定时任务
-----------

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


### 参考

- [yii2-scheduling](https://github.com/omnilight/yii2-scheduling): 定时任务
