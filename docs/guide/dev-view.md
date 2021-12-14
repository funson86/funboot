快速开发常用代码
-------

Table of contents

- Add an editable field in the list grid in backend
- Tree grid
- Multiple selection
- Echarts Chart
- Float label in form
- Simple code of nav

### Add an editable field in the list grid in backend

Add the field to array of protected $editAjaxFields = ['name', 'sort']; in the corresponding Controller. Modify the code like 'name' below in correspond view file.
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

### Tree Grid

Example: Department Management

Controller index()
```
    public function actionIndex()
    {
        $query = $this->modelClass::find()
            ->where(['store_id' => $this->getStoreId()])
            ->orderBy(['id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
        ]);
    }
```

In index.php file of view, use TreeGrid, then modify name field, and delete the filter field.
```php
                <?= \jianyan\treegrid\TreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'parent_id',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'collapsed',
                    ],
                    'options' => ['class' => 'table table-hover tab-treegrid'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false,
                        ],

                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                $str = Html::tag('span', $model->name, ['class' => 'm-l-sm']);
                                $str .= Html::a(' <i class="fa fa-plus"></i>', ['edit-ajax', 'parent_id' => $model['id']], [
                                    'data-toggle' => 'modal',
                                    'data-target' => '#ajaxModal',
                                ]);
                                return Html::tag('span', $str);
                            }
                        ],

                        ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return Html::status($model->status); }],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                        // 'created_by',
                        // 'updated_by',

                        Html::actionsModal(),
                    ]
                ]); ?>

```

In edit.php or edit-ajax.php of view file.
```php
        <?= $form->field($model, 'parent_id')->dropDownList(ActiveModel::getTreeIdLabel()) ?>
```

Add parent_id code in actionEditAjax or actionEdit or beforeEditRender in Controller
```php
        $this->activeFormValidate($model);
        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
```

If you want delete model, refer to code below in controller
```php

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $ids = ArrayHelper::getChildrenIds($id, $this->modelClass::find()->asArray()->all());

        foreach ($ids as $id) {
            $model = $this->findModelAction($id);
            if (!$model) {
                return $this->redirectError(Yii::$app->request->referrer, Yii::t('app', 'Invalid id'));
            }

            if (!$model->delete()) {
                Yii::$app->logSystem->db($model->errors);
                $this->redirectError(Yii::$app->request->referrer);
            }
        }

        return $this->redirectSuccess(Yii::$app->request->referrer, Yii::t('app', 'Delete Successful'));
    }
```

### Multiple selection (checkbox, less than 8)

Example: Multiple Language by checkbox

Add languages field in StoreBase.php

```php
    public $languages;

    public function attributeLabels()
    {
            'languages' => Yii::t('app', 'Language'),
    }
```


Add code in actionEdit() or actionEdit() in StoreController

```php
    public function actionEditAjax()
    {
        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->user_id = Yii::$app->params['defaultUserId'];
            $model->language = ArrayHelper::arrayToInt($post['Store']['languages']);
        }

        $model->languages = ArrayHelper::intToArray($model->language, $this->modelClass::getLanguageLabels());
        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }
```

Add code in edit.php or edit-ajax.php

```php
        <?= $form->field($model, 'languages')->checkboxList(ActiveModel::getLanguageLabels()) ?>
```

### Multiple (select2, may more than 8)

Example use has multiple roles.

add roles filed in UserBase.php, add label in attributeLabels
```php
    public $roles = [];

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'roles' => Yii::t('app', 'Role'),
        ];
    }
```

Show all roles, add code below actionEdit() or actionEdit() in UserController

If Save the relationship of use and role in a new table UserRole.
```php
        $allRoles = ArrayHelper::map(Role::find()->where(['status' => Role::STATUS_ACTIVE])->asArray()->all(), 'id', 'name');

                    // 保存用户角色关系
                    $roles = Yii::$app->request->post('User')['roles'] ?? [];
                    if (count($roles) > 0) {
                        foreach ($roles as $roleId) {
                            $userRole = new UserRole();
                            $userRole->user_id = $model->id;
                            $userRole->role_id = $roleId;
                            if (!$userRole->save()) {
                                Yii::$app->logSystem->db($userRole->errors);
                            }
                        }
                    }


        $model->roles = ArrayHelper::getColumn(UserRole::find()->where(['status' => UserRole::STATUS_ACTIVE])->asArray()->all(), 'role_id');
        return $this->render($this->action->id, [
            'model' => $model,
            'allRoles' => $allRoles,
        ]);
```

If save the relationship of use and role with | to split, add code below actionEdit() or actionEdit() in UserController
```php
        $allUsers = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(), 'id', 'username');

            $heads = Yii::$app->request->post('Department')['heads'];
            if (count($heads) > 0) {
                $model->head = implode('|', $heads);
            }

        $model->heads = explode('|', $model->head);
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'allUsers' => $allUsers,
        ]);
```

Add code in edit.php or edit-ajax.php
```php
                    <?= $form->field($model, 'roles')->widget(kartik\select2\Select2::classname(), [
                        'data' => $allRoles,
                        'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                    ]) ?>
```


### Echarts Chart

In php view file, param server for data url, height for chart height，defaultType for default time type displayed. chartConfig for the buttons on chart.
```php
    <?= \common\widgets\echarts\Echarts::widget([
        'config' => ['server' => Url::to(['stat']), 'height' => '400px', 'defaultType' => 'yesterday'],
        'chartConfig' => ['today', 'yesterday', 'thisWeek', 'thisMonth', 'thisYear'],
    ]) ?>
```

-  cunstom in chartConfig is not supported in Modal popup.

In controller

```php
    public function actionStat($type = 'today')
    {
        $fields = [
            'count' => 'Count',
            'price' => 'Amount',
        ];

        list($time, $format) = EchartsHelper::getFormatTime($type);
        return $this->success(EchartsHelper::lineOrBarInTime(function ($startTime, $endTime, $formatting) {
            return Log::find()
                ->select(['count(*) as count', 'sum(type) as price', "from_unixtime(created_at, '$formatting') as time"])
                ->andWhere(['between', 'created_at', $startTime, $endTime])
                ->groupBy(['time'])
                ->asArray()
                ->all();
        }, $fields, $time, $format));
    }
```

### Float label in form

Modify the label behind the input in template, add css form-label-group

```
<?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
```

add style of .form-label-group in css file

```
/*** floating label ***/
.form-label-group {
    position: relative;
}

.form-label-group input,
.form-label-group label {
    height: 3.125rem;
    padding: .75rem;
}

.form-label-group label {
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    width: 100%;
    margin-bottom: 0; /* Override default `<label>` margin */
    line-height: 1.5;
    color: #495057;
    pointer-events: none;
    cursor: text; /* Match the input under the label */
    border: 1px solid transparent;
    border-radius: .25rem;
    transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
    color: transparent;
}

.form-label-group input::-moz-placeholder {
    color: transparent;
}

.form-label-group input:-ms-input-placeholder {
    color: transparent;
}

.form-label-group input::-ms-input-placeholder {
    color: transparent;
}

.form-label-group input::placeholder {
    color: transparent;
}

.form-label-group input:not(:-moz-placeholder-shown) {
    padding-top: 1.25rem;
    padding-bottom: .25rem;
}

.form-label-group input:not(:-ms-input-placeholder) {
    padding-top: 1.25rem;
    padding-bottom: .25rem;
}

.form-label-group input:not(:placeholder-shown) {
    padding-top: 1.25rem;
    padding-bottom: .25rem;
}

.form-label-group input:not(:-moz-placeholder-shown) ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}

.form-label-group input:not(:-ms-input-placeholder) ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}

.form-label-group input:not(:placeholder-shown) ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}

.form-label-group input:-webkit-autofill ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}
/*** floating label ***/
```


### Simple code of nav
```
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-1" data-toggle="pill" href="#tab-content-1"><?= Yii::t('app', 'Basic info') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-2" data-toggle="pill" href="#tab-content-2"><?= Yii::t('app', 'Advanced') ?></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-content-1">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.
                    </div>
                    <div class="tab-pane fade" id="tab-content-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.
                    </div>
                </div>
                <div class="card-footer">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
                </div>
            </div>
            <!-- /.card -->
        </div>
```

