系统消息
-----------

目录
- 系统日志
- 使用MongoDb存储日志

### 简介

系统消息分为公告、提醒、点对点私信、在线反馈，同时可以支持新用户注册时是否发送提醒给新用户。

也可以自定义类型，根据需求。


### 在线反馈

在线反馈的内容会发送到店铺管理员的消息内容当中。

自定义表单，可以参考在线反馈表单

- common\models\forms\base\FeedbackForm 注意修改字段和翻译，并重定义KEY_FAILED
- frontend/views/site/feedback.php 显示表单

在控制器中添加如下代码，即可显示出对应的在线反馈表单

```php

    public function actionFeedback()
    {
        $resultMsg = null;

        $model = new FeedbackForm();
        $model->checkCaptchaRequired();

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            $resultMsg = Yii::t('app', 'Operate Successfully');
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'resultMsg' => $resultMsg,
        ]);
    }
```
