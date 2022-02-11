<?php

use common\helpers\Html;

?>
<div class="row">
    <div class="col-md-3">
        <a href="compose.html" class="btn btn-primary mb-3">添加数据字典</a>
        <a href="compose.html" class="btn btn-default mb-3">更多操作</a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Folders</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <i class="fas fa-inbox"></i> Inbox
                            <span class="badge bg-primary float-right">12</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-envelope"></i> Sent
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-file-alt"></i> Drafts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-filter"></i> Junk
                            <span class="badge bg-warning float-right">65</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-trash-alt"></i> Trash
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Inbox</h3>

                <div class="card-tools">
                    <a class="btn btn-primary btn-xs" href="#">
                        <i class="fas fa-plus"></i> 创建
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false,
                        ],

                        'id',
                        //'store_id',
                        'name',
                        'description',
                        //'tree',
                        //'type',
                        [
                            'attribute' => 'sort',
                            'value' => function ($model) {
                                return Html::sort($model->sort);
                            },
                            'filter' => false,
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'width: 8%'],
                        ],
                        // ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'created_at:datetime',
                        //'updated_at',
                        //'created_by',
                        //'updated_by',

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{status} {edit} {delete}',
                            'buttons' => [
                                'status' => function ($url, $model, $key) {
                                    return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status);
                                },
                                'permission' => function ($url, $model, $key) {
                                    return Html::buttonModal(['edit-ajax-permission', 'id' => $model->id], '菜单权限', ['class' => 'btn btn-primary btn-sm']);
                                },
                                'department' => function ($url, $model, $key) {
                                    return Html::buttonModal(['edit-ajax-department', 'id' => $model->id], '数据权限');
                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-ajax', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id]);
                                },
                            ],
                        ],
                    ]
                ]); ?>

                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check1">
                                    <label for="check1"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">5 mins ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check2">
                                    <label for="check2"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">28 mins ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check3">
                                    <label for="check3"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">11 hours ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check4">
                                    <label for="check4"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">15 hours ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check5">
                                    <label for="check5"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">Yesterday</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check6">
                                    <label for="check6"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">2 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check7">
                                    <label for="check7"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">2 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check8">
                                    <label for="check8"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">2 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check9">
                                    <label for="check9"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">2 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check10">
                                    <label for="check10"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">2 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check11">
                                    <label for="check11"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">4 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check12">
                                    <label for="check12"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">12 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check13">
                                    <label for="check13"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">12 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check14">
                                    <label for="check14"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">14 days ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" value="" id="check15">
                                    <label for="check15"></label>
                                </div>
                            </td>
                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                            </td>
                            <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                            <td class="mailbox-date">15 days ago</td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-reply"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                    <div class="float-right">
                        1-50/200
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>