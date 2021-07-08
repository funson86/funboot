<?php
use frontend\helpers\Url;
?>

<form method="get" class="list-form list-content-menu-form form-group mb-3" action="<?= Url::to(['/cms/default/search']) ?>">
    <div class="input-search list-content-menu-input-search-dark">
        <button type="submit" class="input-btn input-search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
        <input type="text" class="form-control input-lg" name="keyword" value="<?= Yii::$app->request->get('keyword') ?>" placeholder="<?= Yii::t('app', 'Search keyword') ?>" required="" data-fv-message="不能为空">
    </div>
    <input type='hidden' name='catalog_id' value='<?= Yii::$app->request->get('id', 0) ?>'/>
    <input type='hidden' name='lang' value='<?= Yii::$app->request->get('lang') ?>'/>
</form>
