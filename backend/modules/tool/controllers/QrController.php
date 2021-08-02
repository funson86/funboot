<?php

namespace backend\modules\tool\controllers;

use common\helpers\StringHelper;
use common\models\forms\tool\QrForm;
use Da\QrCode\Contracts\ErrorCorrectionLevelInterface;
use Da\QrCode\Label;
use Da\QrCode\QrCode;
use Yii;
use backend\controllers\BaseController;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

/**
 * Qr
 *
 * Class TreeController
 * @package backend\modules\tool\controllers
 */
class QrController extends BaseController
{
    public function actionIndex()
    {
        $model = new QrForm();
        !$model->content && $model->content = Yii::$app->request->hostInfo;
        !$model->correctionLevel && $model->correctionLevel = ErrorCorrectionLevelInterface::LOW;
        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionEditAjax()
    {
        $model = new QrForm();
        if ($model->load(Yii::$app->request->get())) {
            if (!$model->validate()) {
                throw new UnprocessableEntityHttpException($this->getError($model));
            }

            Yii::$app->response->format = Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', Yii::$app->request->getContentType());

            list($fRed, $fGreen, $fBlue) = sscanf($model->foreground, "#%02x%02x%02x");
            list($bRed, $bGreen, $bBlue) = sscanf($model->background, "#%02x%02x%02x");
            $data = (new QrCode($model->content))
                ->useForegroundColor($fRed, $fGreen, $fBlue)
                ->useBackgroundColor($bRed, $bGreen, $bBlue)
                ->useEncoding('UTF-8')
                ->setErrorCorrectionLevel($model->correctionLevel)
                ->setSize($model->size)
                ->setMargin($model->margin);

            if (!empty($model->logo)) {
                $filePath = StringHelper::getAttachmentPath($model->logo);
                if (file_exists($filePath)) {
                    $data = $data->useLogo($filePath);
                }
                if ($model->logoSize > 0) {
                    $data = $data->setLogoWidth($model->logoSize);
                }
            }

            if (!empty($model->label) && !empty($model->labelSize)) {
                $label = new Label($model->label, null, $model->labelSize, $model->labelAlign, ['t' => 0, 'r' => 10, 'b' => 10, 'l' => '10']);
                $data = $data->setLabel($label);
            }

            return $data->writeString();
        }

    }
}
