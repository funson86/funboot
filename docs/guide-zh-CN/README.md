Funboot开发文档
====================

文档

安装指南
------------

* [系统环境](env.md)
* [系统安装](installation.md)
* [线上发布](publish.md)


系统开发
------------

* [Gii](gii.md)
* [RBAC权限控制](rbac.md)


附录
------------

* [编程规范](code.md)


```
* * * * *  . /etc/profile; /usr/bin/php /www/funboot/yii schedule/run --scheduleFile=/www/funboot/console/runtime/schedule/schedule.php  1>> /dev/null 2>&1
```

composer config -g repo.packagist composer https://packagist.phpcomposer.com

useradd funson
passwd 123456
su funson