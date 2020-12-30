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
* [Gii](dev-gii.md)：优化新加字段再次Gii生成代码覆盖model中的代码问题，同时解决注释生成标签且兼容多语言
* [BaseModel & XxxBase](dev-model.md)：优化新加字段再次Gii生成代码覆盖model中的代码问题，同时解决注释生成标签且兼容多语言
* [BaseController](dev-controller.md)：内置store，优化原gii大量生成相同代码
* [系统组件](dev-component.md)
* [RBAC权限控制组件](dev-rbac.md)：每个用户对应一个角色，不同角色包含不同权限
* [Funboot日志组件](dev-log.md)：后台直接查看指定日志
* [快速开发常用代码](dev-view.md)
* [验收测试](dev-test.md)：优化系统代码变更无需一个个检查
* [定时任务](dev-schedule.md)

### API接口

* [api接口规划](api.md)
* [Swagger接口文档](api-swagger.md)

### 子系统

* [FunPay个人收款系统](https://github.com/funson86/funpay) 演示地址：[https://funpay.mayicun.com/](https://funpay.mayicun.com/)
* [FunCms建站系统](https://github.com/funson86/funcms) 演示地址：[https://funcms.mayicun.com/](https://funcms.mayicun.com/)  [网站模板](https://github.com/funson86/funcms)

附录
------------

* [i18n多语言](appendix-i18n.md)：解决前端/后端/api不同地方重复翻译问题
* [安全](appendix-security.md)
* [PHP编程规范](appendix-code-style.md)
* [代码质量提升](appendix-quality.md)
* [高并发高性能（SnowFlake/Redis/Mongodb/ElasticSearch）](appendix-high.md)
* [Phpstorm插件推荐](appendix-phpstorm.md)

