<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Message as ActiveModel;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\helpers\Markdown;
use yii\helpers\HtmlPurifier;


/* @var $this yii\web\View */
/* @var $model common\models\base\Message */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->parent_id ? Yii::t('app', 'Reply ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];

$userId = Yii::$app->request->get('user_id');
$userIds = ArrayHelper::getColumn(Yii::$app->cacheSystem->getAllStore(), 'user_id');
$allUsers = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'id' => $userIds])->select(['id', 'username'])->asArray()->all(), 'id', 'username');
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if (isset($model->parent)) { ?>
                <?= Html::a('<i class="fa fa-star"></i> ' . Yii::t('cons', 'STATUS_STAR'), ['edit-status', 'id' => $model->parent->id, 'status' => ActiveModel::STATUS_STAR], ['class' => 'btn btn-dark text-warning mr-3']) ?>
                <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('cons', 'STATUS_RECYCLE'), ['delete', 'id' => $model->parent->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>

                <div class="card-tools pt-1">
                    <?= $model->parent->status == ActiveModel::STATUS_STAR ? '<i class="fa fa-star text-warning text-lg"></i>' : '' ?>
                    <?= $model->parent->status == ActiveModel::STATUS_DELETED ? '<i class="fa fa-trash text-danger text-lg"></i>' : '' ?>
                </div>
                <?php } else { ?>
                    <?= $this->title ?>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?php if ($this->context->isAdmin() && !Yii::$app->request->get('user_id')) { ?>
                        <?= $form->field($model, 'user_id')->widget(kartik\select2\Select2::classname(), [
                            'data' => $allUsers,
                            'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                        ]) ?>
                    <?php } elseif (Yii::$app->request->get('user_id')) { ?>
                        <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->select(['id', 'username'])->where(['id' => $userId])->asArray()->all(), 'id', 'username'), ['readonly' => 'readonly']) ?>
                    <?php } else { ?>
                        <?= $form->field($model, 'user_id')->dropDownList([1 => Yii::t('app', 'System Support')], ['readonly' => 'readonly']) ?>
                    <?php } ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?php if ($this->context->isAdmin()) { ?>
                        <?= $form->field($model, 'content')->widget(\common\widgets\markdown\Markdown::class, []) ?>
                    <?php } else { ?>
                        <?= $form->field($model, 'content')->textarea(['rows' => 4]) ?>
                    <?php } ?>
                </div>

                <div class="col-sm-10 col-sm-offset-2">
                    <?= Html::submitButton(Yii::$app->request->get('parent_id') ? Yii::t('app', 'Reply') : Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>

                <?php if ($model->parent_id > 0) { $parent = $model->parent; while ($parent) { ?>
                    <div class="col-sm-10 col-sm-offset-2">
                        <hr>
                        <p class="text-secondary"><?= $parent->from->username ?> <?= Yii::$app->formatter->asDatetime($parent->created_at) ?></p>
                        <h6><?= $parent->name ?></h6>
                        <?php
                        if ($parent->content && strlen($parent->content) > 0) {
                            if ($parent->type == ActiveModel::TYPE_JSON) {
                                $content = json_decode($parent->content, true);
                                echo !is_array($content) ? $content : DetailView::widget([
                                    'model' => $content,
                                    'attributes' => array_keys($content),
                                ]);
                            } elseif ($parent->type == ActiveModel::TYPE_MARKDOWN) {
                                echo HtmlPurifier::process(Markdown::process($parent->content, 'gfm'));
                            } else {
                                echo $parent->content;
                            }
                        } else {
                            echo $parent->messageType->content;
                        }
                        ?>
                    </div>
                <?php $parent = $parent->parent; } } ?>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>