快速开发常用代码
-------

目录

- 列表中增加一个可编辑字段
- 树状表格开发
- 多选字段开发
- Echarts图表

### 列表中增加一个可编辑字段

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

### 树状表格开发
如部门分类等树状表格

Controller中index()
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

view的index.php中，使用TreeGrid，以及修改name字段。因为无法搜索，所有字段的filter都要去掉
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

编辑数据，edit.php或者edit-ajax.php
```php
        <?= $form->field($model, 'parent_id')->dropDownList(ActiveModel::getTreeIdLabel()) ?>
```

在Controller的actionEditAjax或者actionEdit中加入parent_id计算
```php
        $this->activeFormValidate($model);
        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
```

删除需要删除子节点的数据，在Controller中使用如下代码
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

### 多选字段开发（适用于小规模，checkbox）

比如支持的多语言，可选语言

修改StoreBase.php，增加languages字段

```php
    public $languages;

    public function attributeLabels()
    {
            'languages' => Yii::t('app', 'Language'),
    }
```


在StoreController的actionEdit()或者actionEdit()中增加

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
在edit.php或者edit-ajax.php中增加

```php
        <?= $form->field($model, 'languages')->checkboxList(ActiveModel::getLanguageLabels()) ?>
```

### 多选字段开发（适用于大规模，select2）

比如用户可以设置多个角色

首先修改UserBase.php，增加roles字段，以及在attributeLabels增加标签
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

展示用户所有角色，在UserController的actionEdit()或者actionEdit()中增加

显示和保存用户角色，如果是通过新建表的方式
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

显示和保存用户角色，如果是通过|分隔的方式, 在UserController的actionEdit()或者actionEdit()中增加
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

在edit.php或者edit-ajax.php中增加
```php
                    <?= $form->field($model, 'roles')->widget(kartik\select2\Select2::classname(), [
                        'data' => $allRoles,
                        'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                    ]) ?>
```


### Echarts图表

在视图php文件中，server表示后台控制器路径，height表示高度，defaultType表示默认显示时间类型，chartConfig表示显示的图表按钮
```php
    <?= \common\widgets\echarts\Echarts::widget([
        'config' => ['server' => Url::to(['stat']), 'height' => '400px', 'defaultType' => 'yesterday'],
        'chartConfig' => ['today', 'yesterday', 'thisWeek', 'thisMonth', 'thisYear'],
    ]) ?>
```

-  暂时在弹出Modal层的图表中chartConfig不能用custom。

在控制器中
```php
    public function actionStat($type = 'today')
    {
        $fields = [
            'count' => '数量',
            'price' => '价格',
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

### 表单支持浮动标签

需要修改template让label在input后面，并添加 form-label-group 样式， place

```
<?= $form->field($model, 'email', ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group form-label-group']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', ' ')]) ?>
```

css需要添加 .form-label-group

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


### 精简代码 导航
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

