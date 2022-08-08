<?php

namespace api\modules\v21\controllers;

use api\modules\v21\models\Product;

/**
 * Class ProductController
 * @package api\modules\v21\controllers
 * @author funson86 <funson86@gmail.com>
 */
class ProductController extends \api\controllers\BaseController
{
    public $modelClass = Product::class;

    public $optionalAuth = ['*'];

}
