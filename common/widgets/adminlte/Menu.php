<?php

namespace common\widgets\adminlte;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * @package common\widgets\adminlte
 *
 * For example,
 *
 * ```php
 * Menu::widget([
 *      'items' => [
 *          [
 *              'label' => 'Starter Pages',
 *              'icon' => 'tachometer-alt',
 *              'badge' => '<span class="right badge badge-info">2</span>',
 *              'items' => [
 *                  ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
 *                  ['label' => 'Inactive Page', 'iconStyle' => 'far'],
 *              ]
 *          ],
 *          ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
 *          ['label' => 'Yii2 PROVIDED', 'header' => true],
 *          ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
 *          ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
 *          ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
 *          ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
 *      ]
 * ])
 * ```
 *
 * @var array menu item
 * - label: string, the menu item label.
 * - header: boolean, not nav-item but nav-header when it is true.
 * - url: string or array, it will be processed by [[Url::to]].
 * - items: array, the sub-menu items.
 * - icon: string, the icon name. @see https://fontawesome.com/
 * - iconStyle: string, the icon style, such as fas(Solid), far(Regular), fal(Light), fad(Duotone), fab(Brands).
 * - iconClass: string, the whole icon class.
 * - iconClassAdded: string, the additional class.
 * - badge: string, html.
 * - target: string.
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a class="nav-link {class} {active}" href="{url}" {target}>{icon} {label}</a>';

    /**
     * @inheritdoc
     */
    public $labelTemplate = '<p>{label} {treeFlag} {badge}</p>';

    /**
     * @var string treeview wrapper
     */
    public $treeTemplate = "\n<ul class='nav nav-treeview'>\n{items}\n</ul>\n";

    /**
     * @var string
     */
    public static $iconDefault = 'circle';

    /**
     * @var string
     */
    public static $iconStyleDefault = '';

    /**
     * @inheritdoc
     */
    public $itemOptions = ['class' => 'nav-item'];

    /**
     * @inheritdoc
     */
    public $activateParents = true;

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent',
        'data-widget' => 'treeview',
        'role' => 'menu',
        'data-accordion' => 'false'
    ];

    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));

            if (isset($item['items'])) {
                Html::addCssClass($options, 'has-treeview');
            }

            if (isset($item['header']) && $item['header']) {
                Html::removeCssClass($options, 'nav-item');
                Html::addCssClass($options, 'nav-header');
            }

            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $treeTemplate = ArrayHelper::getValue($item, 'treeTemplate', $this->treeTemplate);
                $menu .= strtr($treeTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
                if ($item['active']) {
                    $options['class'] .= ' menu-open';
                }
            }

            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    protected function renderItem($item)
    {
        if (isset($item['header']) && $item['header']) {
            return $item['label'];
        }

        if (isset($item['iconClass'])) {
            $iconClass = $item['iconClass'];
        } else {
            $iconStyle = $item['iconStyle'] ?? static::$iconStyleDefault;
            $icon = $item['icon'] ?? static::$iconDefault;
            $iconClassArr = ['nav-icon', $iconStyle, $icon];
            isset($item['iconClassAdded']) && $iconClassArr[] = $item['iconClassAdded'];
            $iconClass = implode(' ', $iconClassArr);
        }
        $iconHtml = '<i class="'.$iconClass.'"></i>';

        $treeFlag = '';
        if (isset($item['items'])) {
            $treeFlag = '<i class="right fas fa-angle-left"></i>';
        }

        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        return strtr($template, [
            '{label}' => strtr($this->labelTemplate, [
                '{label}' => $item['label'],
                '{badge}' => $item['badge'] ?? '',
                '{treeFlag}' => $treeFlag
            ]),
            '{url}' => isset($item['url']) ? Url::to($item['url']) : '#',
            '{icon}' => $iconHtml,
            '{active}' => $item['active'] ? $this->activeCssClass : '',
            '{class}' => isset($item['class']) ? $item['class'] : '',
            '{target}' => isset($item['target']) ? 'target="'.$item['target'].'"' : ''
        ]);
    }
}
