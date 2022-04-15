<?php

namespace backend\modules\mall\controllers;

use Yii;
use common\models\mall\Coupon;
use common\models\ModelSearch;

/**
 * Coupon
 *
 * Class CouponController
 * @package backend\modules\mall\controllers
 */
class CouponController extends BaseController
{
    /**
      * @var Coupon
      */
    public $modelClass = Coupon::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

}
