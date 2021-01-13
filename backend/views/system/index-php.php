<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\MessageType as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\Url;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'PHP Info');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['index']) ?>"><?= Yii::t('app', 'System Info') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <?php
                ob_start();
                phpinfo();
                $phpinfo = ob_get_contents();
                ob_end_clean();
                $content = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
                $content = str_replace('<table', '<div class="table-responsive"><table class="table table-condensed table-bordered table-striped table-hover config-php-info-table" ', $content);
                $content = str_replace('</table>', '</table></div>', $content);
                echo $content;
                ?>
            </div>
        </div>
    </div>
</div>
