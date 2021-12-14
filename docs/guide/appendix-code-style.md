PHP Funboot 编码规范
----------

Summary

1. PHP file must start with <?php, pule php code file could not ?> at the end.

2. Class must be camel-cases such as StudentModel, StudentController, not use plural such as StudentsController

3. The constant in class must be all uppercase, word separated by underscore, such as：STATUS_ACTIVE

4. Function must be camel-cases starting with lowercase, such as camelCase, getData

5. The file format must be utf-8 without BOM (distinguish ANSI on windows, which is not recognized by other systems)

6. The indent must be 4 Space instead of Tab (Tab may be 8 characters length in linux vim)

7. A blank line must be inserted after namespace declaration statement block.

8. The ({}) of class and function must be in a single line. The attribute and function of class must be with one of private, protected, public. abstract and final must be the frontend of them. The static should be after them.  

There must be a space character after the keyword of the control structure, but not when calling a method or function. The start curly bracket ({) of the control structure must be written on the same line as the declaration, and the end curly bracket (}) must be written on the same line after the body.

summary:

- A blank after keywords
- No blank after (
- No blank before ) 
- A blank between ) and {
- Indent before content.
- } should in a single line at last

```php
<?php

//if esleif esle
if ($expr1) {
    // if body
} elseif ($expr2) {
    // elseif body
} else {
    // else body;
}
```

Note：use `elseif` instead of `else if`, so the keyword only one word.

//switch

```php
<?php
switch ($expr) {
    case 0:
        echo 'First case, with a break';
        break;

    case 1:
        echo 'Second case, which falls through';
        // no break

    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;

    default:
        echo 'Default case';
}
```

//while and do while

```php
<?php
while ($expr) {
    // structure body
}

do {
    // structure body;
} while ($expr);
```

//for and foreach

```php
<?php
for ($i = 0; $i  < 10; $i++) {
    // for body
}
```

//Note: Check the array is empty or not befor foreach
```php
foreach ($iterable as $key => $value) {
    // foreach body
}
```

//try and catch

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

Example：

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

9. PHP all keywords use lowercase. eg: true, false, null

10. closure

When declaring a closure, there must be a space before and after the keyword `function` and `use`

For example：

```php
<?php
$closureWithArgs = function ($arg1, $arg2) {
    // body
};

$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
    // body
};
```
