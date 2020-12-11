<?php

namespace api\modules\v2\controllers;

use api\controllers\BaseController;

/**
 * Default controller for the `v2` module
 */
class DefaultController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/v2/default/index",
     *     @OA\Response(response="200", description="default action for /v2")
     * )
     */
    public function actionIndex()
    {
        return $this->success('v2');
    }
}
