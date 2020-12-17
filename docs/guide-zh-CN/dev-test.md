验收测试
-----------

系统做修改时，每次都要去全部测试可能影响到的地方太麻烦了，因此我们引入自动化测试检查我们的修改影响。

PHP作为动态语言，搭配Yii2框架，整体上做单元测试和功能测试性价比比较低，而对前端做验收测试则是性价比比较高。

### 配置测试

修改frontend/tests/acceptance.suite.yml中的url
```
actor: AcceptanceTester
modules:
    enabled:
        - PhpBrowser:
            url: http://www.funboot.com
        - \Helper\Acceptance
step_decorators: ~        
```

### 编写测试用例

生成新的测试用例

```
windwos平台
.\vendor\bin\codecept.bat generate:cest acceptance Pay

mac linux平台
php ./vendor/bin/codecept generate:cest acceptance Pay

```

参考frontend/tests/acceptance/HomeCest.php文件，根据codeception的验收测试文档编写 https://codeception.com/docs/03-AcceptanceTests




### 运行测试


```
windwos平台
.\vendor\bin\codecept.bat run --steps

mac linux平台
php ./vendor/bin/codecept run --steps

```

### 参考

- https://codeception.com/quickstart
- https://codeception.com/docs/03-AcceptanceTests