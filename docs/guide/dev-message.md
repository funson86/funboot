Message Component
-----------

Table of contents

- Description
- Feedback

### Description

System Message contains board, notice, private message, feedback. suport weather sending message to new user or not while signup.

You can define new message type.

### Feedback

Feedback will be sent to store admin message list.

Define form, refer to feedback form.

- common\models\forms\base\FeedbackForm Modify field and translation, re-define KEY_FAILED
- frontend/views/site/feedback.php Show form

Add code below in the controller, the feedback will be shown in the browser.

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
