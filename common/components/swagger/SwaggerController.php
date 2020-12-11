<?php

namespace common\components\swagger;

use common\components\controller\BaseController;
use common\helpers\Url;
use Yii;
use function OpenApi\scan;

/**
* Swagger
*
* Class ScheduleController
* @package backend\modules\base\controllers
*/
class SwaggerController extends BaseController
{
    /**
     * @var string
     */
    public $swaggerKey = 'swagger:yaml';

    public $scanPath = '@api/controllers';

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $swaggerScanPath = Yii::$app->params['swaggerScanPath'] ?? null;
            if (count($swaggerScanPath) > 0) {
                $this->scanPath = [];
                foreach ($swaggerScanPath as $path) {
                    array_push($this->scanPath, Yii::getAlias($path));
                }
            } else {
                $this->scanPath = Yii::getAlias($this->scanPath);
            }
        }
        return true;
    }

    /**
     * 显示swagger界面
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderFile(__DIR__ . '/views/' . $this->action->id . '.php', [
            'url' => Url::to(['swagger/yaml'])
        ]);
    }

    /**
     * 返回yaml数据
     * @return mixed|string
     */
    public function actionYaml()
    {
        if (!$content = Yii::$app->cache->get($this->swaggerKey)) {
            $openapi = scan($this->scanPath);
            $content = $openapi->toYaml();
            Yii::$app->cache->set($this->swaggerKey, $content);
        }
        return $content;
    }

    /**
     * 刷新数据
     * @return array|mixed
     */
    public function actionRefresh()
    {
        $openapi = scan($this->scanPath);
        $content = $openapi->toYaml();
        Yii::$app->cache->set($this->swaggerKey, $content);
        return $this->success();
    }
}
