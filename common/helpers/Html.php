<?php

namespace common\helpers;

use common\components\enums\Status;
use Yii;

/**
 * Class Html
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class Html extends \yii\helpers\Html
{
    /**
     * a标签，鉴权
     *
     * @param $text
     * @param null $url
     * @param array $options
     * @param bool $check
     * @return string
     */
    public static function a($text, $url = null, $options = [], $check = true)
    {
        if ($url !== null) {
            $options['href'] = Url::to($url, false, $check);
        }

        return static::tag('a', $text, $options);
    }

    /**
     * a标签，鉴权
     *
     * @param $text
     * @param null $url
     * @param array $options
     * @return string
     */
    public static function aRedirect($text, $url = null, $options = [])
    {
        !isset($options['target']) && $options['target'] = '_blank';
        return self::a($text, $url, $options, false);
    }

    /**
     * a标签，鉴权
     *
     * @param $text
     * @param null $url
     * @param array $options
     * @return string
     */
    public static function aHelp($url = null, $text = null, $options = [])
    {
        if (!$url) {
            return null;
        }
        !$text && $text = Yii::t('app', 'Help');
        return self::aRedirect(self::colorLabel($text, 'info'), $url, $options);
    }

    /**
     * 按钮
     * Html::createModal(['edit-ajax'], null, ['size' => 'Large'])
     * Html::createModal(['edit-ajax'], null, ['size' => 'Max'])
     *
     * @param array $url
     * @param String name
     * @param array $options
     * @param bool $modal
     * @param bool $redirect
     * @return string
     */
    public static function buttonModal(array $url, $name, $options = [], $modal = true, $redirect = false, $check = true)
    {
        !$name && $name = Yii::t('app', 'Edit');
        empty($options) && $options = ['class' => "btn btn-default btn-sm"];

        if ($modal) {
            $size = $options['size'] ?? '';
            $options = ArrayHelper::merge([
                'data-toggle' => 'modal',
                'data-target' => '#ajaxModal' . $size,
            ], $options);
        }

        if ($redirect) {
            $options = ArrayHelper::merge(['target' => '_blank'], $options);
        }

        return self::a($name, $url, $options, $check);
    }

    /**
     * 按钮带确认
     *
     * @param $url
     * @param array $options
     * @return string
     */
    public static function buttonConfirm(array $url = ['delete'], $name = null, $options = [])
    {
        if (!$name) {
            $name = Yii::t('app', 'Delete');
        }
        $options = ArrayHelper::merge([
            'class' => 'btn btn-danger btn-sm',
            'onclick' => "fbConfirm(this); return false;"
        ], $options);

        return self::a($name, $url, $options);
    }

    /**
     * 查看
     *
     * @param $url
     * @param array $options
     * @return string
     */
    public static function view(array $url = ['view'], $name = null, $options = [])
    {
        if (!$name) {
            $name = Yii::t('app', 'View');
        }
        $options = ArrayHelper::merge([
            'class' => 'btn btn-default btn-sm',
        ], $options);

        return self::a($name, $url, $options);
    }

    /**
     * 创建按钮
     * Html::createModal(['edit-ajax'], null, ['size' => 'Large'])
     * Html::createModal(['edit-ajax'], null, ['size' => 'Max'])
     *
     * @param array url
     * @param String name
     * @param array $options
     * @return string
     */
    public static function viewModal(array $url = ['view-ajax'], $name = null, $options = [])
    {
        $size = $options['size'] ?? 'Large';
        return self::view($url, $name, array_merge($options, [
            'data-toggle' => 'modal',
            'data-target' => '#ajaxModal' . $size,
        ]));
    }

    /**
     * 创建按钮
     *
     * @param array url
     * @param String name
     * @param array $options
     * @return string
     */
    public static function create(array $url = ['edit'], $name = null, $options = [])
    {
        if (!$name) {
            $name = Yii::t('app', 'Create');
        }
        $options = ArrayHelper::merge([
            'class' => "btn btn-primary btn-sm"
        ], $options);

        $name = '<i class="fa fa-plus"></i> ' . $name;
        return self::a($name, $url, $options);
    }

    /**
     * 创建按钮
     * Html::createModal(['edit-ajax'], null, ['size' => 'Large'])
     * Html::createModal(['edit-ajax'], null, ['size' => 'Max'])
     *
     * @param array url
     * @param String name
     * @param array $options
     * @return string
     */
    public static function createModal(array $url = ['edit-ajax'], $name = null, $options = [])
    {
        !$url && $url = ['edit-ajax'];
        $size = $options['size'] ?? '';
        return self::create($url, $name, array_merge($options, [
            'data-toggle' => 'modal',
            'data-target' => '#ajaxModal' . $size,
        ]));
    }

    /**
     * 编辑按钮
     *
     * @param array url
     * @param String name
     * @param array $options
     * @return string
     */
    public static function edit(array $url = ['edit'], $name = null, $options = [])
    {
        if (!$name) {
            $name = Yii::t('app', 'Edit');
        }

        if (!isset($options['class'])) {
            $options = ArrayHelper::merge([
                'class' => "btn btn-primary btn-sm"
            ], $options);
        }

        return self::a($name, $url, $options);
    }

    /**
     * 编辑按钮
     *
     * @param array url
     * @param String name
     * @param array $options
     * @return string
     */
    public static function editModal(array $url = ['edit-ajax'], $name = null, $options = [])
    {
        return self::edit($url, $name, array_merge($options, [
            'data-toggle' => 'modal',
            'data-target' => '#ajaxModal',
        ]));
    }

    /**
     * 删除
     *
     * @param $url
     * @param array $options
     * @return string
     */
    public static function delete(array $url = ['delete'], $name = null, $options = [])
    {
        if (!$name) {
            $name = Yii::t('app', 'Delete');
        }
        $options = ArrayHelper::merge([
            'class' => 'btn btn-danger btn-sm',
            'onclick' => "fbDelete(this); return false;"
        ], $options);

        return self::a($name, $url, $options);
    }

    /**
     * 状态标签
     *
     * @param int $status
     * @param array $statusLabels
     * @param array $options
     * @return mixed
     */
    public static function status($status = Status::STATUS_ACTIVE, $statusLabels = [], $options = [])
    {
        if (!in_array($status, [Status::STATUS_ACTIVE, Status::STATUS_INACTIVE])) {
            if (empty($statusLabels)) {
                return self::color($status, Status::getLabels($status, true), [], [Status::STATUS_EXPIRED], [], [Status::STATUS_DELETED]);
            } else {
                return self::colorLabel($statusLabels[$status] ?? $status, $options['color'] ?? 'default');
            }
        }

        $buttons = [
            Status::STATUS_ACTIVE => self::tag(
                'div',
                self::tag('span', Status::getLabels(Status::STATUS_ACTIVE), ['class' => "btn btn-success btn-xs"]) . self::tag('span', '&nbsp;', ['class' => "btn btn-default btn-xs"]),
                array_merge(['class' => 'btn-group active-inactive', 'onclick' => "fbStatus(this)", 'data-status' => Status::STATUS_ACTIVE], $options)
            ),
            Status::STATUS_INACTIVE => self::tag(
                'div',
                self::tag('span', '&nbsp;', ['class' => "btn btn-default btn-xs"]) . self::tag('span', Status::getLabels(Status::STATUS_INACTIVE), ['class' => "btn btn-warning btn-xs"]),
                array_merge(['class' => 'btn-group active-inactive', 'onclick' => "fbStatus(this)", 'data-status' => Status::STATUS_INACTIVE], $options)
            ),
        ];

        return isset($buttons[$status]) ? $buttons[$status] : '';
    }

    /**
     * 状态标签
     *
     * @param array $exts
     * @return mixed
     */
    public static function export($url = 'export', $exts = [], $name = null, $options = [])
    {
        !$url && $url = 'export';
        !$name && $name = Yii::t('app', 'Export ');
        empty($exts) && $exts = ['xls', 'xlsx', 'csv', 'html'];

        $options['class'] = $options['class'] ?? 'btn btn-success btn-xs';
        $head = '<button type="button" class="'. $options['class'] . '"><i class="icon ion-ios-cloud-download-outline"></i> ' . $name . '</button><button type="button" class="'. $options['class'] . ' dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
        $links = '';
        $i = 0;
        foreach ($exts as $ext) {
            $links .= self::tag('li', self::a($name . $ext, [$url, 'ext' => $ext]), ['class' => 'dropdown-item']);
            $i++;
            if ($i % 2 == 0 && $i < count($exts)) { // 每2行出一个分隔符
                $links .= self::tag('li', '', ['class' => 'divider']);
            }
        }
        $linksUl = self::tag('ul', $links, ['class' => 'dropdown-menu']);

        return self::tag('div', $head . $linksUl, ['class' => 'btn-group btn-sm']);
    }

    /**
     * 状态标签
     *
     * @param array $exts
     * @return mixed
     */
    public static function groupButton($buttonLinkNames = [], $name = null, $options = [])
    {
        if (empty($buttonLinkNames)) {
            return '';
        }

        if (!$name) {
            $name = Yii::t('app', 'More Actions');
        }

        $options['class'] = $options['class'] ?? 'btn btn-success btn-sm';
        $head = '<button type="button" class="'. $options['class'] . '"><i class="icon ion-ios-cloud-download-outline"></i> ' . $name . '</button><button type="button" class="'. $options['class'] . ' dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
        $links = '';
        $i = 0;
        foreach ($buttonLinkNames as $link => $name) {
            $links .= self::tag('li', self::a($name, [$link]), ['class' => 'dropdown-item']);
            $i++;
            if ($i % 2 == 0 && $i < count($buttonLinkNames)) { // 每2行出一个分隔符
                $links .= self::tag('li', '', ['class' => 'dropdown-divider']);
            }
        }
        $linksUl = self::tag('ul', $links, ['class' => 'dropdown-menu']);

        return self::tag('div', $head . $linksUl, array_merge(['class' => 'btn-group btn-sm'], $options));
    }

    /**
     * 导入按钮
     *
     * @param array url
     * @param String name
     * @param array $options
     * @return string
     */
    public static function import($url = ['import-ajax'], $name = null, $options = [])
    {
        if (empty($url)) {
            $url = ['import-ajax'];
        }

        if (!$name) {
            $name = Yii::t('app', 'Import');
        }
        $options = ArrayHelper::merge([
            'class' => "btn btn-info btn-xs",
            'data-toggle' => 'modal',
            'data-target' => '#ajaxModal',
        ], $options);

        $name = '<i class="icon ion-upload"></i> ' . $name;
        return self::a($name, $url, $options);
    }

    /**
     * 排序
     *
     * @param $value
     * @return string
     */
    public static function sort($value, $options = [])
    {
        $options = ArrayHelper::merge([
            'class' => 'form-control form-sort',
            'onblur' => 'fbSort(this)',
        ], $options);

        return self::input('text', 'sort', $value, $options);
    }

    /**
     * 自定义字段
     *
     * @param $name
     * @param $value
     * @param array $options
     * @return string
     */
    public static function field($name, $value, $options = [])
    {
        $options = ArrayHelper::merge([
            'class' => 'form-control form-' . $name,
            'onblur' => 'fbField(this)',
        ], $options);

        return self::input('text', $name, $value, $options);
    }

    /**
     * 稍微复杂的做跳转 包括view
     *
     * @return array
     */
    public static function actionsRedirect($options = [])
    {
        return [
            'header' => Yii::t('app', 'Actions'),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {edit} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::view(['view', 'id' => $model->id]);
                },
                'edit' => function ($url, $model, $key) {
                    return Html::edit(['edit', 'id' => $model->id]);
                },
                'delete' => function ($url, $model, $key) use ($options) {
                    return Html::delete(['delete', 'id' => $model->id, 'soft' => ($options['soft'] ?? false), 'tree' => ($options['tree'] ?? false)]);
                },
            ],
            'headerOptions' => ['class' => 'action-column'],
        ];
    }

    /**
     * 弹框，适用简单的表，无view
     *
     * @param array $options
     * @return array
     */
    public static function actionsModal($options = [])
    {
        return [
            'header' => Yii::t('app', 'Actions'),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    return Html::editModal(['edit-ajax', 'id' => $model->id]);
                },
                'delete' => function ($url, $model, $key) use ($options) {
                    return Html::delete(['delete', 'id' => $model->id, 'soft' => ($options['soft'] ?? true), 'tree' => ($options['tree'] ?? false)]);
                },
            ],
            'headerOptions' => ['class' => 'action-column'],
        ];
    }

    /**
     * 不弹框，适用复杂表，无view
     *
     * @param array $options
     * @return array
     */
    public static function actionsEditDelete($options = [])
    {
        return [
            'header' => Yii::t('app', 'Actions'),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    return Html::edit(['edit', 'id' => $model->id]);
                },
                'delete' => function ($url, $model, $key) use ($options) {
                    return Html::delete(['delete', 'id' => $model->id, 'soft' => ($options['soft'] ?? false), 'tree' => ($options['tree'] ?? false)]);
                },
            ],
            'headerOptions' => ['class' => 'action-column'],
        ];
    }

    /**
     * 弹框，适用简单的表，无edit
     *
     * @param array $options
     * @return array
     */
    public static function actionsViewDelete($options = [])
    {
        return [
            'header' => Yii::t('app', 'Actions'),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::viewModal(['view-ajax', 'id' => $model->id]);
                },
                'delete' => function ($url, $model, $key) use ($options) {
                    return Html::delete(['delete', 'id' => $model->id, 'soft' => ($options['soft'] ?? false), 'tree' => ($options['tree'] ?? false)]);
                },
            ],
            'headerOptions' => ['class' => 'action-column'],
        ];
    }

    /**
     * 弹框，适用简单的表，无view
     *
     * @param array $options
     * @return array
     */
    public static function actionsDelete($options = [])
    {
        return [
            'header' => Yii::t('app', 'Actions'),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($options) {
                    return Html::delete(['delete', 'id' => $model->id, 'soft' => ($options['soft'] ?? false), 'tree' => ($options['tree'] ?? false)]);
                },
            ],
            'headerOptions' => ['class' => 'action-column'],
        ];
    }

    /**
     * 自定义按钮
     * 如传入  ['edit-modal', 'delete']
     * 如传入  ['view-modal', 'delete']
     *
     * @param array $options
     * @return array
     */
    public static function actionsCustom(array $options = [])
    {
        if (empty($options)) {
            return null;
        }
        $template = '';
        $buttons = [];
        foreach ($options as $option) {
            $str = $option;
            if ($option == 'edit-modal') {
                $str = 'edit';
            } elseif ($option == 'view-modal') {
                $str = 'view';
            }
            $template .= ' {' . $str . '}';

            if ($option == 'status') {
                array_push($buttons, [
                    'status' => function ($url, $model, $key) {
                        return Html::status($model->status);
                    },
                ]);
            }

            if ($option == 'view') {
                array_push($buttons, [
                    'view' => function ($url, $model, $key) {
                        return Html::view(['view', 'id' => $model->id]);
                    },
                ]);
            }

            if ($option == 'view-modal') {
                array_push($buttons, [
                    'view' => function ($url, $model, $key) {
                        return Html::viewModal(['view-ajax', 'id' => $model->id]);
                    },
                ]);
            }

            if ($option == 'edit-modal') {
                array_push($buttons, [
                    'edit' => function ($url, $model, $key) {
                        return Html::editModal(['edit-ajax', 'id' => $model->id]);
                    },
                ]);
            }

            if ($option == 'edit') {
                array_push($buttons, [
                    'edit' => function ($url, $model, $key) {
                        return Html::edit(['edit-ajax', 'id' => $model->id]);
                    },
                ]);
            }

            if ($option == 'delete') {
                array_push($buttons, [
                    'delete' => function ($url, $model, $key) {
                        Html::delete(['delete', 'id' => $model->id]);
                    },
                ]);
            }
        }

        return [
            'header' => Yii::t('app', 'Actions'),
            'class' => 'yii\grid\ActionColumn',
            'template' => $template,
            'buttons' => $buttons,
            'headerOptions' => ['class' => 'action-column action-column-lg'],
        ];
    }

    /**
     * 标签加颜色
     * @param $key
     * @param null $label
     * @param array $success
     * @param array $warning
     * @param array $primary
     * @param array $danger
     * @return string|null
     */
    public static function color($key, $label = null, array $success = [], array $warning = [], array $primary = [], array $danger = [], array $info = [])
    {
        if (is_null($key)) {
            return null;
        }

        $class = 'btn-default';

        if (in_array($key, $success)) {
            $class = 'btn-success';
        } elseif (in_array($key, $warning)) {
            $class = 'btn-warning';
        } elseif (in_array($key, $primary)) {
            $class = 'btn-primary';
        } elseif (in_array($key, $danger)) {
            $class = 'btn-danger';
        } elseif (in_array($key, $info)) {
            $class = 'btn-info';
        }

        return Html::tag('span', $label ?: $key, ['class' => 'btn-xs ' . $class]);
    }

    /**
     * 标签加颜色
     * @param null $label
     * @param string $color  default info danger warning success
     * @return string|null
     */
    public static function colorLabel($label = null, $color = 'info')
    {
        if (!$label || strlen($label) < 1) {
            return $label;
        }

        $class = 'btn-' . $color;
        return Html::tag('span', $label, ['class' => 'btn-xs ' . $class]);
    }
}
