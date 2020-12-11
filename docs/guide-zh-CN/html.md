前端
-------

增加一个新的可以编辑字段，在对应的Controller的 protected $editAjaxFields = ['name', 'sort'];中增加想要编辑的字段，再参考下面的name字段修改字段。
```php
            [
                'attribute' => 'name', 
                'format' => 'raw', 
                'value' => function ($model) { 
                    return Html::field('name', $model->name); 
                }, 
                'filter' => true,
            ],
            [
                'attribute' => 'sort',
                'value' => function ($model) {
                    return Html::sort($model->sort);
                },
                'filter' => false,
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::status($model->status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),
            ],
```

