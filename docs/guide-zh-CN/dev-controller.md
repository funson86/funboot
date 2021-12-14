BaseController
-----------

目录
- common/components/controller/BaseController
- backend/controller/BaseController
- frontend/controller/BaseController
- api/controller/BaseController


> 每个子系统在控制器和Yii原本的Controller中增加了一到两层类，目的是定义一些公共的变量和方法


### common/components/controller/BaseController

由于内置多店多站点，内置变量$store，在beforeAction会根据域名映射到对应的store，并初始化store的配置和生成一些通用数据。

内置$modelClass，如果要使用即定义值即可。

支持跳转带Flash消息的方法。

如果返回一个简单的返回窗口，可以使用$this->htmlSuccess();$this->htmlFailed();

### backend/controller/BaseController

Funboot快速开发平台能快速生成后台基础功能且避免重复代码，后台的默认功能都在backend/controller/BaseController中，要修改只需要覆盖对应的方法即可。

后台支持动态权限判断，在beforeAction中完成权限判断

- 列表 actionIndex，常规表格式列表的和父子树状关系表格，只需修改$style即可切换
- 查看 actionView/ViewAjax，根据ID查看单条数据，xxxAjax为模态框弹出式操作
- 创建/更新 actionEdit/actionEditAjax，未传ID为创建，有ID为更新。xxxAjax为模态框弹出式操作
- 列表页更新字段 actionEditAjaxField，在列表页ajax方式直接更新数据
- 列表页更新状态 actionEditAjaxStatus，在列表页ajax方式直接更新数据的状态，主要为启用/禁用
- 删除 actionDelete，默认假删除即将状态变为删除状态，支持树状删除（删除该节点子孙），有变化根据情况覆盖beforeDeleteModel或afterDeleteModel。
- 清空 actionDeleteAll，真清空，危险操作有变化根据情况覆盖beforeDeleteAll或afterDeleteAll。
- 导出 actionExport，导出数据，指定导出字段覆盖$exportFields即可，并可指定类型
- 导入 actionImportAjax，导入数据（暂时支持xls文件导入），格式和$exportField一样，支持flip翻转


### frontend/controller/BaseController

可以指定前台的一些控制，如不支持多语言的话，强制指定语言为某种语言

### api/controller/BaseController

> 因php不支持多重继承，并不是继承common/components/controller/BaseController 而是继承yii/rest/ActiveController以支持Rest方法

该BaseController重写了一遍变量和方法，完成一个域名对应一个store，并和backend/controller/BaseController重写了一些公共方法

数据的返回格式在api/components/response/Serializer中定义

- 列表 GET actionIndex
- 查看 GET actionView
- 创建 POST actionCreate
- 更新 PUT actionUpdate
- 删除 Delete actionDelete 默认假删除即将状态变为删除状态，支持树状删除（删除该节点子孙），有变化根据情况覆盖beforeDeleteModel或afterDeleteModel。


并支持自定义的$this->success()和$this->error()方法


