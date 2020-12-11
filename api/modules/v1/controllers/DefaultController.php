<?php

namespace api\modules\v1\controllers;

use api\controllers\BaseController;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/v1/default/index",
     *     @OA\Response(response="200", description="default action for /v1")
     * )
     */
    public function actionIndex()
    {
        return $this->success('v1');
    }
}
