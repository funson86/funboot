<?php

namespace common\components\gii\module;

/**
 * Class Generator
 * @package common\components\gii\module
 * @author funson86 <funson86@gmail.com>
 */
class Generator extends \yii\gii\generators\module\Generator
{
    public $baseClass;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['moduleID', 'moduleClass'], 'filter', 'filter' => 'trim'],
            [['moduleID', 'moduleClass', 'baseClass'], 'required'],
            [['moduleID'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            [['moduleClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['moduleClass'], 'validateModuleClass'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'moduleID' => 'Module ID',
            'moduleClass' => 'Module Class',
            'baseClass' => 'DefaultController Base Class',
        ];
    }

}