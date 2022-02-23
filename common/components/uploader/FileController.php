<?php

namespace common\components\uploader;

use common\models\base\Attachment;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class FileController
 * @package common\components\uploader
 * @author funson86 <funson86@gmail.com>
 */
class FileController extends \common\components\controller\BaseController
{

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
    }

    public function actionIndex()
    {
        $json = Yii::$app->request->get('json', false);
        $storeId = Yii::$app->authSystem->isAdmin() ? null : Yii::$app->storeSystem->getId();

        $uploadType = Yii::$app->request->get('upload_type', '');
        $year = Yii::$app->request->get('year', '');
        $month = Yii::$app->request->get('month', '');
        $keyword = Yii::$app->request->get('keyword', '');
        $driver = Yii::$app->request->get('driver', '');

        $query = Attachment::find()
            ->where(['status' => Attachment::STATUS_ACTIVE])
            ->andFilterWhere(['store_id' => $storeId])
            ->andFilterWhere(['upload_type' => $uploadType])
            ->andFilterWhere(['year' => $year])
            ->andFilterWhere(['month' => $month])
            ->andFilterWhere(['like', 'name', $keyword]);

        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10, 'validatePage' =>false]);
        $models = $query->offset($pagination->offset)
            ->orderBy(['id' => SORT_DESC])
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        foreach ($models as &$model) {
            $model['sizeLabel'] = Yii::$app->formatter->asShortSize($model['size']);
        }

        if ($json) {
            return $this->success($models);
        }

        return $this->renderAjax('@common/components/uploader/views/' . $this->action->id, [
            'list' => Json::encode($models),
            'pagination' => $pagination,
            'year' => $year,
            'month' => $month,
            'keyword' => $keyword,
            'driver' => $driver,
            'multiple' => Yii::$app->request->get('multiple', true),
            'boxId' => Yii::$app->request->get('boxId'),
            'uploadType' => Yii::$app->request->get('upload_type', Yii::$app->request->get('upload_type', Attachment::UPLOAD_TYPE_IMAGE)),
        ]);

    }

    public function actionVerifyMd5()
    {
        $md5 = Yii::$app->request->post('md5', null);
        if (!$md5) {
            return $this->success();
        }
        $model = Attachment::find()
            ->where(['status' => Attachment::STATUS_ACTIVE, 'md5' => $md5])
            ->asArray()
            ->one();
        if ($model) {
            $model['sizeLabel'] = Yii::$app->formatter->asShortSize($model['size']);
            return $this->success($model);
        }

        return $this->error();
    }

    public function actionImage()
    {
        $uploader = new Uploader(Yii::$app->request->post(), Attachment::UPLOAD_TYPE_IMAGE);
        if ($model = $uploader->save()) {
            return $this->success($model);
        }
        return $this->error(500);
    }

    public function actionFile()
    {
        $uploader = new Uploader(Yii::$app->request->post(), Attachment::UPLOAD_TYPE_FILE);
        if ($model = $uploader->save()) {
            return $this->success($model);
        }
        return $this->error(500);
    }

    public function actionImageMarkdown()
    {
        $uploader = new Uploader(Yii::$app->request->get(), Attachment::UPLOAD_TYPE_IMAGE);
        $uploader->uploadFileName = 'editormd-image-file';
        if ($model = $uploader->save()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => 1,
                'url' => $model['url'],
            ];
        }

        return $this->error(500);
    }
}