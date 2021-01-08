Api
-------


### 模块规划

- v1 app通用接口，支持相同接口不同版本
- v2 app通用接口，支持相同接口不同版本
- mini 微信小程序api目录
- xx 其他自定义模块接口


### 自定义返回格式

继承api/components/response/ResponseAbstract


### RESTFUL方法
 
|  #   | Method  | URL  | 说明  |
|  ----  | ----  |  ---- |  ---- |
| 列表  | GET | /api/students | 获取列表 |
| 查看  | GET | /api/students/1 | 单个 |
| 创建  | POST | /api/students | 新建，www-form-urlencoded |
| 更新  | PUT | /api/students/1 | 更新，www-form-urlencoded |
| 删除  | DELETE | /api/students/1 | 删除单个 |


![](images/api-rest-index.png)

![](images/api-rest-view.png)

![](images/api-rest-post.png)

![](images/api-rest-put.png)

![](images/api-rest-delete.png)

### 参考

- https://github.com/yiisoft/yii2/blob/master/docs/guide-zh-CN/rest-quick-start.md
