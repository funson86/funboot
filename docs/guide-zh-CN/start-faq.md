常见问题
-------

目录

- linux下提示无访问权限
- 安装或迁移出现 Specified key was too long; max key length is 767 bytes
- 样式修改后访问没有变化
- Class 'COM' not found
- com() has been disabled for security reasons
- 网站访问500错误，index.php无法require根目录其他文件
- Curl访问https://开头的地址错误

### linux下提示无访问权限

- linux下提示无访问权限

linux默认用www帐号运行，没有权限网runtime目录写文件，修改runtime目录权限

```
chmod 777 -R runtime
```


### 安装或迁移出现 Specified key was too long; max key length is 767 bytes

Funboot默认使用utf8mb4，对出现问题的表修改编码为utf8


### 样式修改后访问没有变化

系统会将样式文件发布到assets目录下，删除/web/assets/和/web/backend/assets/下所有文件



### Class 'COM' not found

- Windows下才出现，检查php目录ext文件夹下面php_com_dotnet.dll是否存在

- 在php.ini结尾添加如下代码，重启php-fpm

```
extension=php_com_dotnet.dll
```

- 开始 > 运行 > services.msc 回车 > 确保 COM+ Event System 的服务开启

### com() has been disabled for security reasons

在php.ini中注释掉disable_classes，重启php-fpm

```
; disable_classes = COM
```


### 网站访问500错误，index.php无法require根目录其他文件

由于指定/www/funboot/web目录，/www/funboot/web/.user.ini的路径默认为当前路径，对于项目根路径其他文件无法require

修改.user.ini，将另/www/funboot/web修改为/www/funboot

```
# chattr -i .user.ini

# vi .user.ini
open_basedir=/www/funboot:/tmp/:/proc/

# chattr +i .user.ini
```

### Curl访问https://开头的地址错误

下载证书https://curl.haxx.se/ca/cacert.pem，下载后比如放到c:\路径下

在php.ini中开启ca

```
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo =c:\cacert.pem
```

重启php-fpm或者面板
