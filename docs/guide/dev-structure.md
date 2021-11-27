目录结构
-----------

```
├── api Api接口项目目录
│   ├── components api专用组件目录
│   ├── config 配置目录
│   ├── controllers 控制器目录
│   │   ├── BaseController.php
│   │   └── SiteController.php
│   ├── models 模型，一般继承common/models下的模型
│   ├── modules 依赖如工具类
│   │   ├── base Funboot基础功能模块
│   │   │   ├── controllers 控制器目录
│   │   │   ├── views 视图目录
│   │   │   └── Module.php 模块入口文件
│   │   └── school 其他目录属于自定义功能模块
│   │       ├── controllers 控制器目录
│   │       ├── views 视图目录
│   │       └── Module.php 模块入口文件
│   ├── runtime 运行相关目录，存储程序运行时的日志、缓存等
│   │   ├── cache 缓存文件，清除缓存可以直接删除该目录下的文件和目录
│   │   └── logs 日志
│   └── tests 测试目录
│
├── backend 后台目录
│   ├── assets 资源类目录
│   ├── config 配置目录
│   ├── controllers 控制器目录
│   │   ├── BaseController.php 基础控制器，提供通用的控制方法以及RBAC鉴权
│   │   └── SiteController.php 登录控制相关，与RBAC权限控制无关
│   ├── models 模型，一般继承common/models下的模型
│   ├── modules 依赖如工具类
│   │   ├── base Funboot基础功能模块
│   │   │   ├── controllers 控制器目录
│   │   │   ├── views 视图目录
│   │   │   └── Module.php 模块入口文件
│   │   ├── pay ** Funpay 个人收款支付系统 **
│   │   │   ├── controllers
│   │   │   ├── views
│   │   │   └── Module.php
│   │   └── school 其他目录属于自定义功能模块
│   │       ├── controllers 控制器目录
│   │       ├── views 视图目录
│   │       └── Module.php 模块入口文件
│   ├── runtime 运行相关目录，存储程序运行时的日志、缓存等
│   │   ├── cache 缓存文件，清除缓存可以直接删除该目录下的文件和目录
│   │   └── logs 日志
│   ├── tests 测试目录
│   └── views 视图目录
│       ├── layout 布局文件
│       └── site SiteController默认视图文件
│
├── common 公共目录
│   ├── components 公共组件
│   │   ├── gii Funboot框架gii自动代码生成目录
│   │   └── uploader 上传文件组件
│   ├── config 配置目录
│   ├── helpers 工具类，类似Yii的Helpper，一般都为static静态函数
│   ├── mails 邮件相关
│   ├── helpers 工具类
│   ├── job 队列任务
│   ├── models 工具类
│   │   ├── BaseModel.php 基本模型类，所有的Funboot模型类均继承该类
│   │   ├── base 基础模块
│   │   │   ├── UserModel Gii生成，数据库有变动时可直接覆盖
│   │   │   └── UserBase 和User相关的模型代码写到这里，第一次gii生成后不应再覆盖
│   │   └── school 自定义模块的生成目录
│   ├── messages ** 统一i18n翻译文件 **
│   ├── service model升级版，跨数据表查询
│   ├── widgets 小部件，用于渲染html，一般不含Controller控制器
│
├── console 控制台目录
│   ├── config 配置目录
│   ├── controllers 控制器目录
│   │   ├── BaseController.php 基础控制器，提供通用的控制方法
│   │   └── HeartBeatController.php 登录控制相关，与RBAC权限控制无关
│   ├── migrations 数据库更新迁移
│   ├── models 模型，一般继承common/models下的模型
│   ├── runtime 运行相关目录，存储程序运行时的日志、缓存等
│   │   ├── cache 缓存文件，清除缓存可以直接删除该目录下的文件和目录
│   │   └── logs 日志
│
├── web 网站可访问目录
│   ├── attachment 上传文件
│   ├── backend
│   │   ├── resources 前端资源文件
│   │   └── xboot-vue-template 后台模版
│   └── resources 前端资源文件
└── composer.json 依赖文件

```

- backend/controllers 有BaseController和SiteController，后端所有的类都要继承BaseController, 登录注册相关在SiteController中
- modules/base/controller 基本功能类在这个模块目录下
- modules/your/controller 自定义模块，可以用[Gii](gii.md)生成

如果是开发小型项目可以直接写在backend/controllers中，如果是大型项目则使用

- /common/components 组件目录，集成到代码中，可以提供Controller直接访问
- /common/helpers 公共方法目录，函数都是static，helper一般不与数据库交互
- /common/services 服务，一般有缓存或者队列操作，需要在启动时加载一些数据
- /common/widgets 可重用的小部件，一般会渲染html嵌入到其他代码中，一般不提供Controller访问
