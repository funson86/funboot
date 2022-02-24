<?php
use frontend\helpers\Url;

$this->title = Yii::t('app', 'Payment');
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="page-section payment-index">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12">
                <div class="card message-send-view">
                    <div class="card-header">
                        <?= $this->title ?>
                    </div>

                    <div class="card-body p-5">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://www.paypal.com/sdk/js?client-id=<?= $this->context->store->settings['mall_payment_paypal_client_id'] ?>&components=buttons"></script>
<script>
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color:  'blue',
            shape:  'rect',
            label:  'paypal'
        },
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: 'USD',
                        value: '<?= $model->amount ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            let param = {
                id : <?= $model->id ?>,
                _csrf : '<?= Yii::$app->request->getCsrfToken() ?>'
            };
            $.post('<?= Url::to(['/mall/payment/succeeded']) ?>', param, function(data) {
                if (data.code !== 200) {
                    alert(data.msg);
                    return;
                }
            }, "json");
            Swal.fire('<?= Yii::t('mall', 'You have successfully paid the order') ?>').then((result) => {
                window.location.href = '<?= Url::to(['/mall/payment/succeeded', 'id' => $model->id]) ?>';
            });
        }
    }).render('#paypal-button-container');
</script>

