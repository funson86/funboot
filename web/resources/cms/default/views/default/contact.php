<?php
use frontend\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('cms', 'Contact Us');

$context = $this->context;
$store = $this->context->store;

$this->registerMetaTag(["name" => "keywords", "content" => $store->settings['website_seo_title']]);
$this->registerMetaTag(["name" => "description", "content" => $store->settings['website_seo_description']]);

?>

<section class="page-section bg-light">
    <div class="container">
        <h1 class="text-center pb-5"><?= $context->getBlockValue('home_contact_us') ?></h1>
        <div class="row featurette">

            <div class="col-xs-12 col-sm-12 pt-5 col-md-5 wow bounceIn" data-wow-duration="3s">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 contact-info text-center wow bounceIn" data-wow-duration="3s">
                        <i class="fa fa-envelope-o"></i>
                        <h4 class="contact_title"><?= Yii::t('cms', 'Email') ?></h4>
                        <p class="contact_description"><?= $context->getBlockValueIndex(0, 'home_contact_us', 'brief') ?></p>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 contact-info text-center wow bounceIn" data-wow-duration="3s">
                        <i class="fa fa-map-marker"></i>
                        <h4 class="contact_title"><?= Yii::t('cms', 'Address') ?></h4>
                        <p class="contact_description"><?= $context->getBlockValueIndex(1, 'home_contact_us', 'brief') ?></p>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 contact-info text-center wow bounceIn" data-wow-duration="3s">
                        <i class="fa fa-phone"></i>
                        <h4 class="contact_title"><?= Yii::t('cms', 'Call Us') ?></h4>
                        <p class="contact_description"><?= $context->getBlockValueIndex(2, 'home_contact_us', 'brief') ?></p>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 contact-info text-center wow bounceIn" data-wow-duration="3s">
                        <i class="fa fa-weixin"></i>
                        <h4 class="contact_title"><?= Yii::t('cms', 'WeChat') ?></h4>
                        <p class="contact_description"><?= $context->getBlockValueIndex(3, 'home_contact_us', 'brief') ?></p>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 offset-1" data-wow-duration="3s">
                <div class="card contact-view">
                    <div class="card-header">
                        <?= Html::encode($this->title) ?>
                    </div>

                    <div class="card-body">

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'name', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>

                        <?= $form->field($model, 'mobile', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>

                        <?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['placeholder' => Yii::t('app', ' ')]) ?>

                        <?= $form->field($model, 'content', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->label(false)->textarea(['placeholder' => Yii::t('app', 'Content')]) ?>

                        <div class="form-group text-center pt-3">
                            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary pl-5 pr-5', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php if (strlen($store->settings['website_map']) > 5) { ?>
    <section class="page-section bg-light pt-0" id="home-map">
        <div class="container-fluid p-0" style="overflow: hidden; height: 100%">
            <?= $store->settings['website_map'] ?>
        </div>
    </section>
<?php } ?>

<?php
if (!$resultMsg) return;

$this->registerCssFile('@web/resources/toastr/toastr.min.css');
$this->registerJsFile("@web/resources/toastr/toastr.min.js");

echo "<style>.toast-top-center {top: 200px;}</style>";
$js = <<<JS
toastr.options = {
    "closeButton": true, //是否显示关闭按钮
    "positionClass": "toast-top-center",//弹出窗的位置
    "timeOut": "59000", //展现时间
};
$(document).ready(function () {
    toastr.success("{$resultMsg}");
});
JS;
$this->registerJs($js);
