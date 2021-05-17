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

        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mt-0 mb-1"><?= $model->name ?></h3>
                        <div class="topic-info">
                            <a class="topic-node" href="<?= Url::to(['/bbs/default/index', 'id' => $model->node_id]) ?>"><?= Html::tag('span', $model->node->name, ['class' => 'btn-sm btn-success']) ?></a> •
                            <?= $model->tag_id > 0 ? Html::a($model->tag->name, ['/bbs/default/index', 'ModelSearch[tag_id]' => $model->tag_id], ['class' => 'btn-sm btn-success']) : '' ?> •
                            <a class="remove-padding-left" href="<?= Url::to(['/bbs/topic/view', 'id' => $model->id]) ?>"><span class="bi-hand-thumbs-up"> <?= $model->like ?> </span></a> •
                            <span>最后由<a href="<?= Url::to(['/bbs/user/view', 'id' => $model->user_id]) ?>"><strong> <?= $model->last_comment_username ?> </strong></a>于 <?= Yii::$app->formatter->asDate($model->last_comment_updated_at) ?> 回复</span> •
                            <?= $model->click ?> 次阅读
                        </div>
                    </div>
                    <img src="<?= $model->user->getMixedAvatar() ?>" class="ml-3">
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($model->topicMetas)) { foreach ($model->topicMetas as $item) { ?>
                <p class="mb-2"><?= $item->name ?>: <?= $item->content ?></p>
                <?php } } ?>

                <?php if ($model->format == ActiveModel::FORMAT_MARKDOWN) { ?>
                <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')) ?>
                <?php } else { ?>
                <?= $model->content ?>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?php
                $like = Html::a(
                    Html::tag('i', '', ['class' => 'bi-hand-thumbs-up']) . Html::tag('span', $model->like) . ' 个赞',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_LIKE,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->like) ? 'icon-active' : ''
                    ]);

                $hate = Html::a(
                    Html::tag('i', '', ['class' => 'bi-hand-thumbs-down']) . ' 踩',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_HATE,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->hate) ? 'icon-active' : ''
                    ]
                );

                $follow = Html::a(
                    Html::tag('i', '', ['class' => 'bi-eye']) . ' 关注',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_FOLLOW,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->follow) ? 'icon-active' : ''
                    ]
                );
                $thanks = Html::a(
                    Html::tag('i', '', ['class' => 'bi-heart']) . ' 感谢',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_THANKS,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->thanks) ? 'icon-active' : ''
                    ]
                );
                $favorite = Html::a(
                    Html::tag('i', '', ['class' => 'bi-bookmark']) . ' 收藏',
                    '#',
                    [
                        'data-action' => UserAction::ACTION_FAVORITE,
                        'data-type' => UserAction::TYPE_TOPIC,
                        'data-id' => $model->id,
                        'class' => ($model->favorite) ? 'icon-active' : ''
                    ]
                );


                if ($model->isOwner() || $this->context->isAdmin()) {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-hand-thumbs-up']) . ' ' . Html::tag('span', $model->like) . ' 个赞',
                        'javascript:;'
                    );
                } else {
                    echo $like, $hate, $thanks;
                }
                echo $follow, $favorite;

                if ($this->context->isAdmin()) {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-trophy']) . ' ' . ($model->grade == ActiveModel::GRADE_EXCELLENT ? '取消' : '') . '加精',
                        ['/bbs/topic/excellent', 'id' => $model->id, 'cancel' => $model->grade == ActiveModel::GRADE_EXCELLENT ? 1 : 0],
                        ['class' => ($model->grade == ActiveModel::GRADE_EXCELLENT ? 'icon-active' : '')]
                    );
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-arrow-up-circle']) . ' ' . ($model->sort == 10 ? '取消' : '') . '置顶',
                        ['/bbs/topic/top', 'id' => $model->id, 'cancel' => $model->sort == 10 ? 1 : 0],
                        ['class' => ($model->sort == 10 ? ' icon-active' : '')]
                    );
                }

                if ($model->isOwner() || $this->context->isAdmin()) {
                    echo '<span class="float-right">';
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-pencil']) . ' 修改',
                        ['/bbs/topic/edit', 'id' => $model->id]
                    );
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'bi-trash']) . ' 删除',
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
        </div>
    </div><!-- /.col-lg-4 -->

</div>

