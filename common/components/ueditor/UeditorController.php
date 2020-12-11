<?php

namespace common\components\ueditor;

use common\components\controller\BaseController;
use common\components\uploader\Uploader;
use common\helpers\ArrayHelper;
use common\models\base\Attachment;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use Exception;

/**
 * Class UeditorController
 * @package common\components\ueditor
 * @author funson86 <funson86@gmail.com>
 */
class UeditorController extends BaseController
{
    public $config;

    public $actions = [
        'config' => 'config',
        'catchimage' => 'catch-image',
        'uploadimage' => 'image',
        'uploadscrawl' => 'scrawl',
        'uploadvideo' => 'video',
        'uploadfile' => 'file',
        'listinfo' => 'list-info',
        'listimage' => 'list-image',
        'listfile' => 'list-file',
    ];

    /**
     * 行为控制
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;

        $this->config = [
            // server config @see http://fex-team.github.io/ueditor/#server-config
            'scrawlMaxSize' => Yii::$app->params['uploaderConfig']['image']['maxSize'],
            'videoMaxSize' => Yii::$app->params['uploaderConfig']['video']['maxSize'],
            'imageMaxSize' => Yii::$app->params['uploaderConfig']['image']['maxSize'],
            'fileMaxSize' => Yii::$app->params['uploaderConfig']['file']['maxSize'],
            'imageManagerListPath' => Yii::$app->params['uploaderConfig']['image']['path'],
            'fileManagerListPath' => Yii::$app->params['uploaderConfig']['file']['path'],
            'scrawlFieldName' => 'image',
            'videoFieldName' => 'file',
            'fileFieldName' => 'file',
            'imageFieldName' => 'file',
        ];

        $configPath = Yii::getAlias('@common') . "/components/ueditor/";
        // 保留UE默认的配置引入方式
        if (file_exists($configPath . 'config.php')) {
            $config = require($configPath . 'config.php');
            $this->config = ArrayHelper::merge($config, $this->config);
        }
    }


    /**
     * 返回
     * @param string $state
     * @param string $url
     * @return string[]
     */
    protected function result($state = 'ERROR', $url = '')
    {
        return [
            "state" => $state,
            "url" => $url,
        ];
    }

    /**
     * 后台统一入口
     *
     * @return array|mixed
     */
    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $action = strtolower(Yii::$app->request->get('action', 'config'));
        if (isset($this->actions[$action])) {
            return $this->run($this->actions[$action]);
        }

        return $this->result('', 'error');
    }

    public function actionConfig()
    {
        return $this->config;
    }

    public function actionImage()
    {
        try {
            $uploader = new Uploader(Yii::$app->request->get(), Attachment::UPLOAD_TYPE_IMAGE);
            if ($model = $uploader->save()) {
                return $this->result('SUCCESS', $model['url']);
            }
        } catch (Exception $e) {
            Yii::$app->logSystem->db($e->getMessage());
            return $this->result($e->getMessage());
        }

        return $this->result();
    }

    public function actionFile()
    {
        try {
            $uploader = new Uploader(Yii::$app->request->get(), Attachment::UPLOAD_TYPE_FILE);
            if ($model = $uploader->save()) {
                return $this->result('SUCCESS', $model['url']);
            }
        } catch (Exception $e) {
            Yii::$app->logSystem->db($e->getMessage());
            return $this->result($e->getMessage());
        }

        return $this->result();
    }

    public function actionVideo()
    {
        try {
            $uploader = new Uploader(Yii::$app->request->get(), Attachment::UPLOAD_TYPE_VIDEO);
            if ($model = $uploader->save()) {
                return $this->result('SUCCESS', $model['url']);
            }
        } catch (Exception $e) {
            Yii::$app->logSystem->db($e->getMessage());
            return $this->result($e->getMessage());
        }

        return $this->result();
    }

    public function actionListImage()
    {
        return $this->getAttachment($this->config['imageManagerListSize'], $this->config['imageManagerListPath']);
    }

    public function actionListFile()
    {
        return $this->getAttachment($this->config['fileManagerListSize'], $this->config['fileManagerListPath']);
    }

    public function getAttachment($size, $path)
    {
        $start = Yii::$app->request->get('start', 0);
        $uploadType = ($path == $this->config['imageManagerListPath']) ? 'image' : 'file';
        $query = Attachment::find()
            ->where(['status' => Attachment::STATUS_ACTIVE])
            ->andWhere(['upload_type' => $uploadType])
            //->andFilterWhere(['store_id' => $this->getStoreId()])
            ->orderBy(['id' => SORT_DESC]);
        $query1 = clone $query;
        $count = $query1->count();

        $models = $query
            ->orderBy(['id' => SORT_DESC])
            ->offset($start)
            ->limit($size)
            ->asArray()
            ->all();
        return [
            'state' => 'SUCCESS',
            'list' => $models,
            'start' => $start,
            'total' => $count,
        ];
    }
}