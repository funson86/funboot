Saas
-----------

目录
- 多域名
- 多子系统
- 平台形式
- Saas下的配置权限控制
- 多语言 & 自动翻译
- 多货币

### 多域名

在后台添加store时，需要指定域名host_name，支持|分隔多个域名，即aaa.funboot.com|bbb.funboot.com可以是指向同一个店铺

### 多子系统

每个店铺可以切换到不同的子系统


### 平台形式

支持平台 https://www.funboot.com/store-mayicun 和 https://www.funboot.com/123，需要在添加store的时候，将code设置为mayicun

平台形式下，host_name可以是其他相同的二级域名如www1.funboot.com，这样superadmin从后台登录的时候不会引发从www.funboot/backend/登出。


### Saas下的配置权限控制

超级管理员登录到用户的系统后台，可以配置管理、店铺管理员的权限
 
### 多语言 & 自动翻译

- 参考 [多语言 & 自动翻译](dev-lang.md)

### 多货币

开发中


