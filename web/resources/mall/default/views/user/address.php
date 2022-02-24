
<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Address');
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

                        <?= Html::a('<i class="fa fa-plus-circle"></i> ' . Yii::t('app', 'Create ') . Yii::t('app', 'Address'), ['/mall/address/edit'], ['class' => 'btn btn-primary control-full mb-3']) ?>

                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemOptions' => ['class' => 'list-group-item border-0 p-0'],
                            'summary' => false,
                            'itemView' => '_' . $this->context->action->id,
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
