Acceptance test
-----------

It is no need to test every function every time after edit some code, it is convenient to use automated test check the functions.  

PHP is a dynamic language, with Yii2 framework, it no need to do unit test and functional test. The acceptance test is the best.

### Config

Modify url in frontend/tests/acceptance.suite.yml

```
actor: AcceptanceTester
modules:
    enabled:
        - PhpBrowser:
            url: http://www.funboot.com
        - \Helper\Acceptance
step_decorators: ~        
```

### Test Case

Generate new test case

```
windwos
.\vendor\bin\codecept.bat generate:cest acceptance Pay

mac linux
php ./vendor/bin/codecept generate:cest acceptance Pay

```

In frontend/tests/acceptance/HomeCest.php, write codeception refer to https://codeception.com/docs/03-AcceptanceTests




### Run


```
windwos
.\vendor\bin\codecept.bat run --steps

mac linux
php ./vendor/bin/codecept run --steps

```

### References

- https://codeception.com/quickstart
- https://codeception.com/docs/03-AcceptanceTests