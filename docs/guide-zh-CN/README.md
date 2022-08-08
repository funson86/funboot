Funboot开发文档
====================

文档

### 安装指南

* [系统简介](../../README.md)
* [系统环境](start-env.md)
* [系统安装](start-installation.md)
* [常见问题](start-faq.md)


### 系统开发

* [目录结构](dev-structure.md)
* [约定优先配置](dev-convention.md)
* [Saas说明](dev-saas.md)
* [Gii](dev-gii.md)：优化新加字段再次Gii生成代码覆盖model中的代码问题，同时解决注释生成标签且兼容多语言
* [BaseModel & XxxBase](dev-model.md)：优化新加字段再次Gii生成代码覆盖model中的代码问题，同时解决注释生成标签且兼容多语言
* [BaseController](dev-controller.md)：内置store，优化原gii大量生成相同代码
* [系统组件](dev-component.md)
* [RBAC权限控制组件](dev-rbac.md)：每个用户对应一个角色，不同角色包含不同权限
* [日志组件](dev-log.md)：后台直接查看指定日志
* [消息组件](dev-message.md)：群发消息&在线反馈
* [多语言 & 自动翻译](dev-lang.md)：内容多语言并自动翻译
* [快速开发常用代码](dev-view.md)
* [验收测试](dev-test.md)：优化系统代码变更无需一个个检查
* [定时任务](dev-schedule.md)
* [Websocket](dev-websocket.md)


### API接口

* [api接口规划](api.md)
* [Swagger接口文档](api-swagger.md)
* [OAuth 2.0](oauth2.md)


### 子系统

* [Funboot开发平台](https://github.com/funson86/funboot) 演示地址：[https://www.funboot.net/backend/](https://www.funboot.net/backend/) test 123456
* [FunPay个人收款系统](https://github.com/funson86/funpay) 演示地址：[https://funpay.funboot.net/](https://funpay.funboot.net/)
* [FunCms建站系统](https://github.com/funson86/funcms) 演示地址：[https://funcms.funboot.net/](https://funcms.funboot.net/)  [网站模板](https://github.com/funson86/funcms)
* [FunBBS论坛系统](https://github.com/funson86/funbbs) 演示地址：[https://funbbs.funboot.net/](https://funbbs.funboot.net/)  [说明](https://github.com/funson86/funbbs)
* [FunMall商城系统](https://github.com/funson86/funmall) 演示地址：[https://funmall.funboot.net/](https://funmall.funboot.net/)  [说明&模板](https://github.com/funson86/funmall)
* [FunChat聊天室](https://github.com/funson86/yii2-websocket) 演示地址：[https://chat.funboot.net/](https://chat.funboot.net/)  [说明&模板](https://github.com/funson86/yii2-websocket)


### 第三方组件

* [Redis](3rd-redis.md)
* [Mongodb](3rd-mongodb.md)
* [Elasticsearch](3rd-elasticsearch.md)

附录
------------

* [i18n多语言](appendix-i18n.md)：解决前端/后端/api不同地方重复翻译问题
* [安全](appendix-security.md)
* [PHP编程规范](appendix-code-style.md)
* [代码质量提升](appendix-quality.md)
* [高并发高性能（SnowFlake/Redis/Mongodb/ElasticSearch）](appendix-high.md)
* [Phpstorm插件推荐](appendix-phpstorm.md)


### 使用的技术栈
- [Yii 2](http://www.yiiframework.com/): 2.0系列最新版
- [Adminlte 3.x](https://adminlte.io/): Adminlte 3.x [文档](https://adminlte.io/docs/3.0/components/main-header.html)
- [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet): 导入导出数据
- [File System](https://github.com/thephpleague/flysystem): 文件系统
- [OAuth 2.0](https://github.com/thephpleague/oauth2-server): OAuth 2.0授权
- [IP地址](https://github.com/zhuzhichao/ip-location-zh): 根据IP获取地址相关信息
- [Uuid](https://github.com/ramsey/uuid):分布式ID
- [SnowFlake](https://github.com/godruoyi/php-snowflake): 分布式ID
- [Easy Wechat](https://github.com/jianyan74/yii2-treegrid): Easy Wechat微信公众号小程序开发
- [php-simple-html-dom-parser](https://github.com/Kub-AT/php-simple-html-dom-parser): 简单Html Dom分析器，适用要求不高的采集
- [Workerman](https://github.com/walkor/Workerman): 基于Workerman的Websocket开发，系统提供一个带历史消息的聊天室
- [Pinyin](https://github.com/overtrue/pinyin): 拼音
- [Treegrid](https://github.com/jianyan74/yii2-treegrid): Yii树状表
- [yii2-scheduling](https://github.com/omnilight/yii2-scheduling): 定时任务
- [Swagger](https://github.com/zircote/swagger-php): Api文档生成
- [Qrcode](https://github.com/2amigos/qrcode-library): 二维码  [文档](https://qrcode-library.readthedocs.io/en/latest/)
- [IconPicker](https://github.com/itsjavi/fontawesome-iconpicker): fontawesome图标选择器
- [Toastr](https://github.com/CodeSeven/toastr): 通知提示框
- [Sweetalert2](https://github.com/sweetalert2/sweetalert2): 弹窗
- [Kartik Widgets](https://github.com/kartik-v/yii2-widget-datetimepicker): Kartik 各种组件
- [jsTree](https://www.jstree.com/): 树状选择框


### V1.1更新

- 代码更加规整
- 支持列表页自定义筛选（可在后台商城-》商品管理参考样例）
- 支持列表页按照全选、全选当前条件（可在后台商城-》商品管理参考样例）
- 修复部分bug
