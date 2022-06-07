<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use common\models\bbs\UserAction;
use common\models\bbs\Topic as ActiveModel;

/* @var $model \common\models\bbs\Topic */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name;

$comment = new \common\models\bbs\Comment();
$comment->topic_id = $model->id;
?>

<div class="row">
    <div class="col-md-9">

        <div class="card topic-view">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mt-0 mb-1"><?= $model->grade  == ActiveModel::GRADE_EXCELLENT ? Html::tag('span', '精', ['class' => 'badge badge-pill badge-info']) : '' ?> <?= $model->name ?><?= $model->status == ActiveModel::STATUS_INACTIVE ? ' ' . Html::a(Yii::t('app', 'Pass'), ['/bbs/topic/pass', 'id' => $model->id], ['class' => 'btn btn-sm btn-success']) : '' ?></h3>
                        <div class="topic-info">
                            <a class="topic-node" href="<?= Url::to(['/bbs/default/index', 'id' => $model->node_id]) ?>"><?= Html::tag('span', $model->node->name, ['class' => 'btn-sm btn-info']) ?></a> •
                            <?= $model->tag_id > 0 ? Html::a($model->tag->name, ['/bbs/default/index', 'ModelSearch[tag_id]' => $model->tag_id], ['class' => 'btn-sm btn-info']) : '' ?> •
                            <a class="remove-padding-left" href="<?= Url::to(['/bbs/topic/view', 'id' => $model->id]) ?>"><span class="fa fa-thumbs-o-up"> <?= $model->like ?> </span></a> •
                            <?php if ($model->comment > 0) { ?>
                            <span>最后由 <a href="<?= Url::to(['/bbs/user/view', 'id' => $model->last_comment_user_id]) ?>"><strong> <?= $model->last_comment_username ?> </strong></a>于 <?= Yii::$app->formatter->asDate($model->last_comment_updated_at) ?> 回复 •
                            <?php } else { ?>
                            <span>由 <a href="<?= Url::to(['/bbs/user/view', 'id' => $model->user_id]) ?>"><strong> <?= $model->username ?> </strong></a>于 <?= Yii::$app->formatter->asDate($model->created_at) ?> 发布 •
                            <?php } ?>
                            <?= $model->click ?> 次阅读
                        </div>
                    </div>
                    <img class="rounded-circle" src="<?= $model->user->getMixedAvatar() ?>" class="ml-3" width="50" height="50">
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($model->topicMetas)) { foreach ($model->topicMetas as $item) { ?>
                <p class="mb-2"><?= $item->name ?>: <?= $item->content ?></p>
                <?php } } ?>

                <?php if ($model->format == ActiveModel::FORMAT_MARKDOWN) { ?>
                <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')) ?>
                <?php } elseif ($model->format == ActiveModel::FORMAT_TEXTAREA) { ?>
                <?= nl2br($model->content) ?>
                <?php } else { ?>
                <?= $model->content ?>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?php
                $like = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . Html::tag('span', $model->like) . ' 个赞',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_LIKE,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->like) ? 'icon-active' : ''
                    ]);

                $hate = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-down']) . ' 踩',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_HATE,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->hate) ? 'icon-active' : ''
                    ]
                );

                $follow = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_FOLLOW,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->follow) ? 'icon-active' : ''
                    ]
                );
                $thanks = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-heart-o']) . ' 感谢',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_THANKS,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->thanks) ? 'icon-active' : ''
                    ]
                );
                $favorite = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-bookmark-o']) . ' 收藏',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_FAVORITE,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->favorite) ? 'icon-active' : ''
                    ]
                );


                if ($model->isOwner()) {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like) . ' 个赞',
                        'javascript:;'
                    );
                } else {
                    echo $like, $hate, $thanks;
                }
                echo $follow, $favorite;

                if ($this->context->isManager()) {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trophy']) . ' ' . ($model->grade == ActiveModel::GRADE_EXCELLENT ? '取消' : '') . '加精',
                        ['/bbs/topic/excellent', 'id' => $model->id, 'cancel' => $model->grade == ActiveModel::GRADE_EXCELLENT ? 1 : 0],
                        ['class' => ($model->grade == ActiveModel::GRADE_EXCELLENT ? 'icon-active' : '')]
                    );
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-arrow-circle-o-up']) . ' ' . ($model->sort == 10 ? '取消' : '') . '置顶',
                        ['/bbs/topic/top', 'id' => $model->id, 'cancel' => $model->sort == 10 ? 1 : 0],
                        ['class' => ($model->sort == 10 ? ' icon-active' : '')]
                    );
                }

                if ($model->isOwner() || $this->context->isManager()) {
                    echo '<span class="float-right">';
                    if ($model->status != ActiveModel::STATUS_ACTIVE) {
                        echo Html::a(
                            Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 审核通过',
                            ['/bbs/topic/pass', 'id' => $model->id]
                        );
                    }
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                        ['/bbs/topic/edit', 'id' => $model->id]
                    );
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                        ['/bbs/topic/delete', 'id' => $model->id],
                        [
                            'data' => [
                                'confirm' => "您确认要删除文章「{$model->name}」吗？",
                                'method' => 'post',
                            ],
                        ]
                    );
                }
                ?>

            </div>
        </div>

        <?= $model->is_comment ? $this->render('../comment/index', ['model' => $comment, 'topic' => $model, 'dataProvider' => $dataProvider]) : 0 ?>

        <?= $model->is_comment ? $this->render('../comment/create', ['model' => $comment]) : '' ?>


    </div>

    <div class="col-md-3 pl-0">
        <div class="sidebar-fixed">
            <?= \frontend\widgets\BbsSidebar::widget(['type' => 'topic', 'nodeId' => $model->node_id]) ?>
            <?= \common\widgets\base\StuffWidget::widget(['style' => 1, 'codeId' => $model->node_id]) ?>
        </div>
    </div><!-- /.col-lg-4 -->

</div>

