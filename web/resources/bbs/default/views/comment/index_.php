<?php

use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Html;
use common\models\bbs\Comment;

/** @var \common\models\bbs\Comment $model */

$index = 1 + $widget->dataProvider->pagination->page * $widget->dataProvider->pagination->pageSize;

?>

<div class="media p-0">
    <?= \yii\helpers\Html::img($model->user->getMixedAvatar(50), ['class' => 'mr-3 rounded-circle', 'width' => 50, 'height' => 50]);?>
    <div class="media-body">
        <div class="mt-0">
            <?= $model->user->name ?: \common\helpers\StringHelper::secretEmail($model->user->email) ?>
            <div class="float-right">
                <?php if ($model->isOwner()) {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-hand-thumbs-up']) . ' ' . Html::tag('span', $model->like) . ' 个赞 ',
                        'javascript:;'
                    );

                    echo Html::a('',
                        ['/bbs/comment/update', 'id' => $model->id],
                        ['title' => '修改回帖', 'class' => 'bi-pencil']
                    ) . ' ';
                    echo Html::a('',
                        ['/bbs/comment/delete', 'id' => $model->id],
                        [
                            'title' => '删除回复',
                            'class' => 'bi-trash',
                            'data' => [
                                'confirm' => "您确认要删除回复吗？",
                                'method' => 'post',
                            ],
                        ]
                    );
                } else {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-hand-thumbs-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                        '#',
                        [
                            'data-do' => 'like',
                            'data-id' => $model->id,
                            'data-type' => 'comment',
                            'class' => ($model->like) ? 'active' : ''
                        ]
                    );
                }
                ?>
            </div>
        </div>

        <p><?= $model->status == Comment::STATUS_ACTIVE ? nl2br($model->content) : Yii::t('app', 'Delete') ?></p>
    </div>
</div>
