<?php
use common\models\base\Recharge;
use yii\helpers\Html;

/** @var Recharge $model */

$this->title = Yii::t('app', 'One more step');

$currency = $this->context->store->settings['payment_currency'] ?? '$';
$store = $this->context->store;

$timeLeft = 15 * 60 - (time() - $model->created_at);

$urlRechargeNotify = Yii::$app->urlManager->createAbsoluteUrl(['/site/recharge-notify', 'id' => $model->id]);
?>

<div class="row page-section">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card message-send-view">
            <div class="card-header text-center">
                <?= Html::encode($this->title) ?>
            </div>

            <div class="card-body">
                <div class="form-group py-3">
                    <?php if ($timeLeft > 0) { ?>
                        <p>You recharge has been submit, please click "PAY CARD" button above and follow the instructions.</p>
                        <button id="submitButton" class="btn btn-danger control-full py-2 text-lg"> <?= Yii::t('app', 'Pay Card') ?></button>
                        <p class="text-attention"><i class="fas fa-exclamation-triangle text-primary"></i> Please wait for the confirmation page after you pay on the third-party payment platforms.</p>
                        <p class="text-center"><span class="btn btn-info">Expired <span id="timerLabel"></span></span>

                    <?php } else { ?>

                        <p class="attention-icon"><i class="fa fa-close text-danger"></i></p>
                        <h5 class="text-center mb-3"><?= Yii::t('app', 'Expired') ?></h5>

                        <?= Html::a(Yii::t('app', 'Back to Recharge'), ['/base/recharge/edit-new'], ['class' => 'btn btn-theme control-full mt-3']) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var maxtime = <?= $timeLeft ?>;
function CountDown() {
    if (maxtime > 0) {
        minutes = Math.floor(maxtime / 60);
        seconds = Math.floor(maxtime % 60);
        msg = " in [" + minutes + ":" + seconds + "] minutes";
        $('#timerLabel').html(msg)
        // if (maxtime == 5 * 60)alert("还剩5分钟");
        --maxtime;
    } else if (maxtime == 0) {
        clearInterval(timer);
        window.location.reload();
    }
}

$(document).ready(function(){
    timer = setInterval(CountDown, 1000);
});

$('#submitButton').click(function () {
    window.location.href = '<?= $urlRechargeNotify ?>';
})
</script>
