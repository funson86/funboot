PHP Funboot 编码规范
----------

概览

1. PHP代码文件必须以  <?php ，纯 php 代码不用加 ?> 结束,如果使用闭合标签，任何由开发者，用户，git或者FTP应用程序插入闭合标签后面的空格都有可能会引起多余的输出、php错误、之后的输出无法显示、空白页。因此，所有的php文件应该省略这个php闭合标签，并插入一段注释来标明这是文件的底部并定位这个文件在这个应用的相对路径。

2. 类的命名必须遵循写开头的驼峰命名规范,如StudentModel, StudentController；类命名尽量不使用复数如StudentsController

3. 类中的常量所有字母都必须大写，单词间用下划线分隔 如：STATUS_ACTIVE

4. 方法名称必须符合小写开头驼峰命名规范 如 camelCase, getData

5. 编码格式使用无 BOM 输出(主要是用在 Windows 上用与区分ANSI编码，其它系统则不识别)的 utf-8 编码

6. 代码必须使用4个空格符而不是 tab键进行缩进(Tab有可能会跳8个空格，有些编辑器是4个空格)。

7. 每个 namespace 命名空间声明语句和 use 声明语句块后面，必须插入一个空白行。

8. 类的开始花括号({)必须写在函数声明后自成一行，结束花括号(})也必须写在函数主体后自成一行，方法的开始花括号({)必须写在函数声明后自成一行，结束花括号(})也必须写在函数主体后自成一行。类的属性和方法必须 添加访问修饰符（private、protected 以及 public）， abstract 以及 final 必须声明在访问修饰符之前，而 static 必须声明在访问修饰符之后,控制结构的关键字后必须要有一个空格符。

控制结构的关键字后必须要有一个空格符，而调用方法或函数时则一定不能有，控制结构的开始花括号({)必须写在声明的同一行，而结束花括号(})必须写在主体后自成一行。

控制结构总结：

- 控制结构关键词后必须有一个空格。
- 左括号 ( 后一定不能有空格。
- 右括号 ) 前也一定不能有空格。
- 右括号 ) 与开始花括号 { 间一定有一个空格。
- 结构体主体一定要有一次缩进。
- 结束花括号 } 一定在结构体主体后单独成行。

```php
<?php

//if esleif esle 语句
if ($expr1) {
    // if body
} elseif ($expr2) {
    // elseif body
} else {
    // else body;
}
```

注：应该使用关键词 elseif 代替所有 else if ，以使得所有的控制关键字都像是单独的一个词。

//switch 语句

```php
<?php
switch ($expr) {
    case 0:
        echo 'First case, with a break';
        break;

    case 1:
        echo 'Second case, which falls through';
        no break

    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;

    default:
        echo 'Default case';
}
```

//while 和 do while

```php
<?php
while ($expr) {
    // structure body
}

do {
    // structure body;
} while ($expr);
```

//for 和 foreach

```php
<?php
for ($i = 0; $i  < 10; $i++) {
    // for body
}
```

//注意在执行 foreach 前要进行判断，为空就不要执行了
```php
foreach ($iterable as $key => $value) {
    // foreach body
}
```

//try 和 catch

```php
<?php
try {
    // try body
} catch (FirstExceptionType $e) {
    // catch body
} catch (OtherExceptionType $e) {
    // catch body
}
```

总范例：

```php
<?php

namespace Vendor\Package;
use FooInterface;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class Foo extends Bar implements FooInterface
{

    public function sampleFunction($a, $b = null)
    {
        if ($a === $b) {
            bar();
        } elseif ($a > $b) {
            $foo->bar($arg1);
        } else {
            BazClass::bar($arg2, $arg3);
        }
    }

    final public static function bar()
    {
        // method body
    }
}
```

9. PHP所有 关键字必须全部小写，如 true, false, null

10. 闭包

闭包声明时，关键词 function 后以及关键词 use 的前后都必须要有一个空格。

例：

```php
<?php
$closureWithArgs = function ($arg1, $arg2) {
    // body
};

$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
    // body
};
```
