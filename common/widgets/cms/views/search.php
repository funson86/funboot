
<form method="get" class="list-form list-content-menu-form form-group" action="<?= Yii::$app->urlManager->createUrl(['cms/default/search']) ?>">
    <input type='hidden' name='catalog_id' value='<?= Yii::$app->request->get('id', 0) ?>'/>
    <div class="input-search list-content-menu-input-search-dark">
        <button type="submit" class="input-btn input-search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
        <input type="text" class="form-control input-lg" name="keyword" value="<?= Yii::$app->request->get('keyword') ?>" placeholder="请输入搜索关键词！" required="" data-fv-message="不能为空">
    </div>
</form>
