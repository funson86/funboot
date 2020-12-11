<?php

namespace api\modules\mini\controllers;

use api\controllers\BaseController;

/**
 * @OA\Info(title="Mini", version="1.0")
 */
class DefaultController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/mini/default/index",
     *     @OA\Response(response="200", description="default action for /mini")
     * )
     */
    public function actionIndex()
    {
        return $this->success();
    }
}
