<?php

namespace common\widgets\jstree;

use yii\helpers\Json;
use yii\widgets\InputWidget;
use common\widgets\jstree\assets\AppAsset;

/**
 * Class JsTree
 *
 * ```php
 *
 * $defaultData = [
 *    [
 *      'id' => 1,
 *      'parent_id' => 0,
 *      'name' => '测试1',
 *    ],
 *    [
 *      'id' => 2,
 *      'parent_id' => 0,
 *      'name' => '测试2',
 *    ],
 *    [
 *      'id' => 3,
 *      'parent_id' => 0,
 *      'name' => '测试3',
 *    ],
 *    [
 *      'id' => 4,
 *      'parent_id' => 1,
 *      'name' => '测试4',
 *    ],
 * ];
 *
 * $selectIds = [1, 2];
 *
 * ```
 *
 * @package common\widgets\jstree
 * @author funson86 <funson86@gmail.com>
 */
class JsTree extends InputWidget
{
    /**
     * ID
     *
     * @var
     */
    public $name;
    /**
     * @var string
     */
    public $theme = 'default';
    /**
     * 默认数据
     *
     * @var array
     */
    public $defaultData = [];
    /**
     * 选择的ID
     *
     * @var array
     */
    public $selectIds = [];
    /**
     * 过滤掉的ID
     *
     * @var array
     */
    protected $filtrationId = [];

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();

        $defaultData = $this->defaultData;
        $selectIds = $this->selectIds;
        // 获取下级没有全部选择的ID
        $this->filtration(self::itemsMerge($defaultData));

        $filtrationIds = [];
        foreach ($this->filtrationId as $filtrationId) {
           $filtrationIds = array_merge($filtrationIds, array_column(self::getParents($defaultData, $filtrationId), 'id'));
        }

        $jsTreeData = [];
        foreach ($defaultData as $datum) {
            $data = [
                'id' => $datum['id'],
                'parent' => !empty($datum['parent_id']) ? $datum['parent_id'] : '#',
                'text' => trim($datum['name']),
                // 'icon' => 'none'
            ];

            $jsTreeData[] = $data;
        }

        // 过滤选择的ID
        foreach ($selectIds as $key => $selectId) {
            if (in_array($selectId, $filtrationIds)) {
                unset($selectIds[$key]);
            }
        }

        return $this->render($this->theme, [
            'name' => $this->name,
            'selectIds' => Json::encode(array_values($selectIds)),
            'defaultData' => Json::encode($jsTreeData),
        ]);
    }

    /**
     * 过滤
     *
     * @param $data
     */
    public function filtration($data)
    {
        foreach ($data as $datum) {
            if (!empty($datum['-'])) {
                $this->filtration($datum['-']);

                if (in_array($datum['id'], $this->selectIds)) {
                    $ids = array_column($datum['-'], 'id');
                    $selectChildIds = array_intersect($this->selectIds, $ids);

                    if (count($selectChildIds) != count($ids)) {
                        $this->filtrationId[] = $datum['id'];
                    }
                }
            }
        }
    }

    /**
     * 传递一个子分类ID返回所有的父级分类
     *
     * @param array $items
     * @param $id
     * @return array
     */
    public static function getParents(array $items, $id)
    {
        $arr = [];
        foreach ($items as $v) {
            if (is_numeric($id)) {
                if ($v['id'] == $id) {
                    $arr[] = $v;
                    $arr = array_merge(self::getParents($items, $v['parent_id']), $arr);
                }
            }
        }

        return $arr;
    }

    /**
     * 递归
     *
     * @param array $items
     * @param int $parentId
     * @param string $idField
     * @param string $parentIdField
     * @param string $child
     * @return array
     */
    protected static function itemsMerge(array $items, $parentId = 0)
    {
        $arr = [];
        foreach ($items as $v) {
            if (is_numeric($parentId)) {
                if ($v['parent_id'] == $parentId) {
                    $v['-'] = self::itemsMerge($items, $v['id']);
                    $arr[] = $v;
                }
            }
        }

        return $arr;
    }

    /**
     * 注册资源
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        AppAsset::register($view);
    }
}