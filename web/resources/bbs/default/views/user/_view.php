<?php
/**
 * @Author: forecho
 * @Date  :   2015-01-29 23:26:54
 * @Last  Modified by:   forecho
 * @Last  Modified time: 2015-02-04 21:53:45
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

?>
<?php switch (Yii::$app->request->get('type', 'view')) {
    case 'index':
        // 回复
        if ($model->topic) {
            echo Html::a(
                Html::encode($model->topic->name),
                ["/bbs/topic/view", 'id' => $model->topic->id],
                ['class' => 'list-group-item-heading']
            );
            echo Html::tag('span', Yii::$app->formatter->asDate($model->created_at),
                ['class' => 'ml5 fade-info']);
            echo Html::tag('div', nl2br($model->content), ['class' => 'markdown-reply']);
        }
        break;
    case 'favorite':
    case 'like':
        // 收藏
        echo Html::tag('i', '', ['class' => 'fa fa-bookmark red mr5']);

        echo Html::a(
            Html::encode($model->topic->name),
            ["/bbs/topic/view", 'id' => $model->topic->id],
            ['class' => 'list-group-item-heading']
        );
        echo Html::tag('span', Yii::$app->formatter->asRelativeTime($model->topic->created_at),
            ['class' => 'ml5 fade-info']);
        echo Html::beginTag('p', ['class' => 'list-group-item-text title-info']);

        echo Html::a($model->topic->node->name,
            ["/bbs/node/view", 'node' => $model->topic->node->id]);
        echo ' • ';
        echo Html::beginTag('span');
        echo "{$model->topic->like} 个赞 • {$model->topic->comment} 条回复";
        echo Html::endTag('span');
        echo Html::endTag('p');
        break;

    case 'point':
        // 积分
        echo Html::tag('i', '', ['class' => 'fa fa-money red mr5']);
        echo Html::encode($model->brief);
        echo Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at), ['class' => 'ml5 fade-info']);
        break;
} ?>