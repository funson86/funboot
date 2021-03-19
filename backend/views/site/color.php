<style>
    .sp-replacer {
        background: #fff;
    }
    .spectrum-group > .input-group-addon {
        padding: 4px 0;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <?= \kartik\color\ColorInput::widget([
                    'name' => 'color',
                    'value' => $value,
                    'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'readonly' => true],
                ]);?>
            </div>
        </div>
    </div>
</div>
