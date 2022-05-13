
<?php
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Order');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-section">
    <div class="container">
        <div class="row page-center">
            <div class="col-md-12 p-0">
                <div class="card message-send-view">
                    <div class="card-header">
                        <?= $this->render('_nav', ['type' => $this->context->action->id]) ?>
                    </div>

                    <div class="card-body py-5">

                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemOptions' => ['class' => 'list-group-item border-0 p-0'],
                            'summary' => false,
                            'itemView' => $this->context->action->id . '_',
                            'options' => ['class' => 'list-group'],
                            'pager' => [
                                'options' => ['class' => 'pagination user-pagination'],
                                'pageCssClass' => 'page-item',
                                'linkOptions' => ['class' => 'page-link'],
                                'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link prev disabled'],
                                'maxButtonCount' => 5
                            ],

                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
